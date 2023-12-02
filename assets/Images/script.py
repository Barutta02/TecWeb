import os

def rinomina_immagini(cartella_origine, cartella_destinazione):
    # Ottieni la lista di nomi delle immagini dalla cartella origine
    nomi_immagini_origine = sorted(os.listdir(cartella_origine))
    print("Nomi immagini origine:", nomi_immagini_origine)

    # Ottieni la lista di nomi delle immagini dalla cartella destinazione
    nomi_immagini_destinazione = sorted(os.listdir(cartella_destinazione))
    print("Nomi immagini destinazione:", nomi_immagini_destinazione)

    # Assicurati che entrambe le cartelle abbiano lo stesso numero di immagini
    if len(nomi_immagini_origine) != len(nomi_immagini_destinazione):
        print("Errore: Il numero di immagini nelle due cartelle non corrisponde.")
        return

    # Rinomina le immagini nella cartella di destinazione
    for i in range(len(nomi_immagini_origine)):
        vecchio_nome = os.path.join(cartella_destinazione, nomi_immagini_destinazione[i])
        nuovo_nome = os.path.join(cartella_destinazione, nomi_immagini_origine[i])

        os.rename(vecchio_nome, nuovo_nome)
       # print(f"Rinominato: {nomi_immagini_destinazione[i]} -> {nomi_immagini_origine[i]}")

# Specifica le cartelle origine e destinazione
cartella_origine = "sushi_plates_size50x50"
cartella_destinazione = "sushi_plates"

# Chiama la funzione per rinominare le immagini
rinomina_immagini(cartella_origine, cartella_destinazione)
