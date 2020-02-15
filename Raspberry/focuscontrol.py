import threading

lock = threading.Lock()

#If the focus is being used returns failure notification, if not aquires lock and adjusts amount
def adjust_focus(amount):
    if not lock.acquire(False):
        return  'The focus motor is adjusting. This adjustment will not be processed.'
    else:
        try:
            #put focus adjustment code here
            return True
        finally:
            lock.release()
            return 'The focus has been adjusted by ' + str(amount) + 'successfully'
