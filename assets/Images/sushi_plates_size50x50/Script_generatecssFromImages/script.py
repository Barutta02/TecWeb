import os

def generate_css(folder_path, output_file):
    with open(output_file, 'w') as css_file:
        css_file.write('/* Generated CSS from Python */\n\n')

        for filename in os.listdir(folder_path):
            if filename.endswith('.jpg') or filename.endswith('.png'):
                image_name, extension = os.path.splitext(filename)
                css_rule = f".imageMenuItem.{image_name} {{\n"
                css_rule += f"    background-image: url(../assets/Images/sushi_plates_size50x50/{filename});\n"
                css_rule += "}\n\n"
                css_file.write(css_rule)

if __name__ == "__main__":
    folder_path = "../"
    output_file = "output.css"

    generate_css(folder_path, output_file)
    print(f"CSS file '{output_file}' generated successfully.")
