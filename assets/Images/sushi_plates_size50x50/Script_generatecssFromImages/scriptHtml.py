import os

def generate_html(folder_path):
    # Lista dei nomi delle immagini nella cartella
    image_names = [f.replace('.jpg', '') for f in os.listdir(folder_path) if f.endswith('.jpg')]

    # Creazione del file HTML
    with open('output.html', 'w') as html_file:
        html_file.write('<!DOCTYPE html>\n<html>\n<head>\n<style>\n')
        html_file.write('.menuItem { border: 1px solid #ccc; padding: 10px; margin: 10px; }\n')
        html_file.write('.imageMenuItem { width: 50px; height: 50px; background-color: lightblue; }\n')
        html_file.write('.infoItem { display: inline-block; vertical-align: top; margin-left: 10px; }\n')
        html_file.write('</style>\n</head>\n<body>\n')

        # Creazione del blocco HTML per ogni immagine
        for image_name in image_names:
            html_file.write('<div class="menuItem">\n')
            html_file.write(f'  <div class="imageMenuItem {image_name}"></div>\n')
            html_file.write('  <div class="infoItem">\n')
            html_file.write(f'    <dt class="nomePiatto">{image_name}</dt>\n')
            html_file.write('    <dd class="ingradienti">Salmone, riso</dd>\n')
            html_file.write('    <dd class="prezzo">4€</dd>\n')
            html_file.write('  </div>\n</div>\n')

        html_file.write('</body>\n</html>')

# Specifica il percorso della cartella delle immagini
folder_path = '../'
generate_html(folder_path)
