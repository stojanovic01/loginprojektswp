
import hashlib 
 
# Beispieltext 
text = "teacherleaveuskidsalone" 
 
# SHA-256 berechnen 
hash_object = hashlib.sha256(text.encode("utf-8")) 
checksum = hash_object.hexdigest()  # als Hex-String 
 
print(f"Text: {text}") 
print(f"SHA-256 Checksumme: {checksum}") 