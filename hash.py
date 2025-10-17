import hashlib

def hash_password(password: str) -> str:
    return hashlib.sha256(password.encode()).hexdigest()

# Eingabe des Passworts
password = input("Gib dein Passwort ein: ")
hashed_password = hash_password(password)

print(f"Gehashtes Passwort: {hashed_password}")