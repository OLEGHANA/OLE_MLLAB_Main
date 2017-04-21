#!/usr/bin/python
#!/usr/bin/env python
import subprocess
import sys
import os

total = len(sys.argv)
cmdargs = str(sys.argv)
sudoPassword = 'oleole'

command = 'sudo sox -t mp3 http://192.168.0.111:5984/radio_resources/'+ str(sys.argv[2]) +'/'+ str(sys.argv[2]) +'.mp3 -t wav -  | sudo PiFmRds/src/./pi_fm_rds -freq ' + str(sys.argv[1]) + ' -audio -'
#p = sys('echo %s|sudo -S %s' % (sudoPassword, command))
os.system('echo %s|sudo -S %s' % (sudoPassword, command))

###sudo sox -t mp3 str(sys.argv[1]) -t wav -  | sudo ./pi_fm_rds -freq str(sys.argv[2]) -audio -

 

