import os
import re
import errno
import magic



folder = "res"

flags = os.O_CREAT | os.O_EXCL | os.O_WRONLY

try:
	file_handle = os.open('variables.txt', flags)
except OSError as e:
	if e.errno == errno.EEXIST:  # Failed as the file already exists.
		dicvar = open("variables.txt", "r")
		firstchar = dicvar.read(1)
		variables = []
		if not firstchar:
			print ("LOL")
			variables = []
		else:
			variables = open("variables.txt").read().splitlines()
	else:  # Something unexpected went wrong so reraise the exception.
		raise
else:  # No exception, so the file must have been created successfully.
	with os.fdopen(file_handle, 'w') as file_obj:
		variables = []
		# Using `os.fdopen` converts the handle to an object that acts like a
		# regular Python file object, and the `with` context manager means the
		# file will be automatically closed when we're done with it.
		file_obj.write("")

for file in os.listdir(folder):
	# print file
	regex = re.compile(r'([^A-Z\'\(\$]G_)\w+', re.UNICODE)
	regexF = re.compile(r'([^A-Z\'\(\$]F_)\w+', re.UNICODE)

	filepath = os.path.join(folder, file)
	count = 0

	blob = open(filepath).read()
	m = magic.Magic(mime_encoding=True)
	encoding = m.from_buffer(blob)
	print encoding

	while regex.search(open(filepath, 'r', re.UNICODE).read()) is not None:
		f = open(filepath, 'r')
		contentOfFile = f.read()
		finding = regex.search(contentOfFile)
		varName = contentOfFile[finding.start()+1:finding.end()]
		stringToReplace = "GL(" + varName + ",'" + varName +"',0)"
		newContent = contentOfFile[:finding.start()+1] + stringToReplace + contentOfFile[finding.end():]
		print (newContent)
		fileW = open(filepath, "w")
		fileW.write(newContent)
		count += 1
		if varName in variables:
			pass
		else:
			variables.append(varName)
		f.close()
		fileW.close()

	while regexF.search(open(filepath, 'r', re.UNICODE).read()) is not None:
		f = open(filepath, 'r')
		contentOfFile = f.read()
		finding = regexF.search(contentOfFile)
		varName = contentOfFile[finding.start()+1:finding.end()]
		stringToReplace = "GL(" + varName + ",'" + varName +"',0)"
		newContent = contentOfFile[:finding.start()+1] + stringToReplace + contentOfFile[finding.end():]
		print (newContent)
		fileW = open(filepath, "w")
		fileW.write(newContent)
		count += 1
		if varName in variables:
			pass
		else:
			variables.append(varName)
		f.close()
		fileW.close()

	print (variables)
	print (count)

dic = open("variables.txt", "w")
for item in variables:
  dic.write("%s\n" % item)
dic.close()
