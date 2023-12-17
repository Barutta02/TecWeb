import os

def rinomina_con_nomi_ripetuti(directory, nomi):
    # Ottieni la lista di tutti i file nella directory
    files = os.listdir(directory)

    # Calcola il numero di file nella directory e il numero di nomi nella lista
    num_files = len(files)
    num_nomi = len(nomi)

    for i in range(num_files):
        # Crea il percorso completo del file
        vecchio_percorso = os.path.join(directory, files[i])

        # Ottieni l'estensione del file
        estensione = os.path.splitext(files[i])[1]

        # Ottieni il nuovo nome del file dalla lista (con ripetizione) mantenendo l'estensione
        nuovo_nome = nomi[i % num_nomi] + estensione

        # Crea il nuovo percorso completo del file
        nuovo_percorso = os.path.join(directory, nuovo_nome)

        # Rinomina il file
        os.rename(vecchio_percorso, nuovo_percorso)
        print(f"File rinominato: {files[i]} -> {nuovo_nome}")

# Specifica la directory in cui desideri rinominare i file
directory_da_rinominare = "sushi_plates"

# Specifica la lista di nomi desiderati
nomi_desiderati = ["nigiridisalmone", "makicalifornia", "sashimiditonno", "tempuradigamberi", "menusushideluxe", "dragonroll", "uramakiphilly", "tartaredisalmone", "gyozadiverdure", "rolldiavocado", "tatakidimanzo", "makisalmoneeavocado", "sashimimisto", "tempuradiverdure", "menusushipremium", "rainbowroll", "uramakitempura", "tartareditonno", "gyozadipollo", "rollvegano", "nigiriditonno"]

# Chiama la funzione per rinominare i file mantenendo le estensioni
rinomina_con_nomi_ripetuti(directory_da_rinominare, nomi_desiderati)
