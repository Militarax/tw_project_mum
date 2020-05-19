import mysql.connector
from mysql.connector import Error
from mutagen.id3 import ID3
import os
import requests
from bs4 import BeautifulSoup
import re


mypath = os.getcwd()
onlyfiles = [f for f in os.listdir(mypath) if os.path.isfile(os.path.join(mypath, f))]
onlymp3 = [i for i in onlyfiles if i.endswith(".mp3")]

def getMutagenTags(path):
    audio = ID3(path)
    try:
        author = audio['TPE1'].text[0]
    except KeyError:
        author = ""
    try: 
        name_track = audio["TIT2"].text[0]
    except KeyError:
        name_track = ""
    try:
        album = audio['TALB'].text[0]
    except KeyError:
        album = ""
    return [author, name_track, album]


def insert_track(my_tuple):
    try:
        connection = mysql.connector.connect(host='localhost',
                                             database='mydb',
                                             user='root')
        if connection.is_connected():
            cursor = connection.cursor()
            query = """insert into `track` (`id`, `id_artist`, `title_track`) values(NULL, %s, %s)"""
            result = cursor.execute(query, my_tuple)
            connection.commit()
    except Error as e:
        print("Error while connecting to MySQL", e)
    finally:
        if (connection.is_connected()):
            cursor.close()
            connection.commit()
            print("MySQL connection is closed")




def parse(name):
    r = requests.get('https://en.wikipedia.org/wiki/'+name.replace(" ",'_'));
    html = ""
    real_name = ""
    born = ""
    genre = ""
    bio = ""
    
    try:
        if r.status_code == 200:
            soup = BeautifulSoup(r.text, "lxml");
            table = soup.find("table")
            if table is not None:
                if table.find("div", class_="nickname") is not None:
                    real_name = table.find("div", class_="nickname").text
                if table.find_all("span")[1] is not None:
                    born = table.find_all("span")[1].text
                img_link = table.img['src']
                for i in table.find_all("tr"):
                    if i.th != None:
                        if i.th.text == "Genres":
                            td = i.td
                            if td.div != None:
                                genre = i.td.find("div").ul.li.text
                            else:
                                genre = td.a.text



                
                for i in soup.table.next_siblings:
                    html += str(i)
                soup = BeautifulSoup(html, "lxml");

                html = ""
                div = soup.find("div")
                for i in soup.find_all('p'):
                    if div not in i.next_siblings:
                        break
                    html += str(i)
    except Error as e:
        print(e)

    soup = BeautifulSoup(html, "lxml")

    return {"real_name": real_name, "born" : born, "genre" : genre, "bio" : re.sub(r"\[[0-9]*\]", "", soup.text), "img_link" : img_link}


try:
    connection = mysql.connector.connect(host='localhost',
                                         database='mydb',
                                         user='root')
    if connection.is_connected():
        for i in onlymp3:
            author, name_track, album = getMutagenTags(i)
            cursor = connection.cursor()
            select_query = """select count(*), id from artists where name = %s"""
            result = cursor.execute(select_query, (author,))
            records = cursor.fetchall()
            
            if records[0][0] == 1:
                insert_track((records[0][1], name_track))

            else:
                wiki_info = parse(author)
                insert_query = """insert into `artists` (`id`, `name`, `wiki`, `real_name`, `born`, `genre`, `img_link`) values (NULL, %s, %s, %s, %s, %s, %s)"""
                result = cursor.execute(insert_query, (author, wiki_info['bio'], wiki_info['real_name'], wiki_info['born'], wiki_info['genre'], wiki_info['img_link'],))
                connection.commit()

                result = cursor.execute(select_query, (author,))
                records = cursor.fetchall()
                insert_track((records[0][1], name_track))
            
            
            insert_rss_query = """insert into `rss` (`id`, `title`, `link`, `description`, `date`) values (NULL, %s, %s, %s, current_timestamp())"""
            result = cursor.execute(insert_rss_query, ("New track!","index.php", "A new track was added " + author + " - " + name_track,))
            connection.commit()
            
            id_artist = records[0][1]

            select_album_query = """select count(*), album_title, img_link from `albums` GROUP by id_artist, album_title, img_link HAVING id_artist = %s"""
            result  = cursor.execute(select_album_query, (id_artist,))
            records = cursor.fetchall()
            
            found = False
            for row in records:
                if row[0] != 0 and album == row[1]:
                    insert_album_query = """insert into `albums` (`id`, `album_title`, `id_track`, `id_artist`, `img_link`) values (NULL, %s, (select max(id) from track), %s, %s)"""
                    result = cursor.execute(insert_album_query, (album, id_artist, row[2], ))
                    connection.commit()
                    found = True

            if found == False:
                print("Give me the link to album image to album " + album)
                album_image_link = input()
                insert_album_query = """insert into `albums` (`id`, `album_title`, `id_track`, `id_artist`, `img_link`) values (NULL, %s, (select max(id) from track), %s, %s)"""
                result = cursor.execute(insert_album_query, (album, id_artist, album_image_link, ))
                connection.commit()
                

except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if (connection.is_connected()):
        cursor.close()
        connection.close()
        print("MySQL connection is closed")