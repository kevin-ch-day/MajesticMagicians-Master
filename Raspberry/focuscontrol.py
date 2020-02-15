import threading


#Single controller for focus. Executes one focus adjustment request at a time. Drops requests while adjusting focus
class FocusControl():

    lock = threading.Lock()
    
    def request_focus_adjust(amount):
        if not lock.acquire(False):
            return  'The focus is currently adjusting. This adjustment will not be processed.'
        else:
            is_adjust_correct = False
            try:
                is_adjust_correct = focus_adjust(amount)
            except:
                pass
            finally:
                result_str = ''
                if is_adjust_correct:
                    result_str = 'The focus has been adjusted by ' + str(amount) + '.'
                else:
                    result_str = 'The focus stopped sometime while adjusting by ' + str(amount) + '.'
                lock.release()
                return result_str

    def _focus_adjust(amount):
        lock.acquire()
        try:
            #Code to interface with motor
            #Wait while motor moving (depends on if this will be controlled by a timer or feedback from the motor)
            #If any errors return false
            pass
        except:
            pass
        finally:
            lock.release()
