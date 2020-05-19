from mutagen.id3 import ID3
import os
mypath = os.getcwd()
onlyfiles = [f for f in os.listdir(mypath) if os.path.isfile(os.path.join(mypath, f))]

print(onlyfiles) 

def getMutagenTags(path):
	audio = ID3(path)
	return audio["TIT2"].text[0]


for file_name in onlyfiles:
	if file_name.endswith(".mp3"):
		os.rename(file_name,'%s.mp3' % getMutagenTags(file_name));