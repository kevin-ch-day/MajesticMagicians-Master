import threading

lock = threading.Lock()

def boolean adjust_focus(amount):
    if not lock.acquire(False):
        return  'The focus motor is adjusting. This adjustment will not be processed.'
    else:
        try:
            #put focus adjustment code here
        finally:
            lock.release()
            return 'The focus has been adjusted by ' + str(amount) + 'successfully'
