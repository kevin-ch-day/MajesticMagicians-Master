import threading
import time

lock = threading.Lock()
isNewTime = False

def turn_on_light(duration):
    startTime = time.time()
    if lock.locked():
        isNewTime = True
        notifyAll()
        while lock.locked():
            sleep(0.1)
    
    lock.aquire()
    try:
        #code to interface with light turn on goes here
        this.endTime = startTime + duration
        while !isNewTime and time.time() < this.endTime:
            sleepTime = float((endTime - currentTime) / 2)
            sleep(sleepTime)
    finally:
        turn_off_light()
        isNewTime = False
        lock.release()
        notifyAll()
        
def turn_off_light():
    lock.aquire()
    try:
        #code to interface with light turn off goes here
    finally:
        lock.release()
        

            
    
