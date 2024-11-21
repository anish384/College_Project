from flask import Flask, render_template, request, send_file
import pandas as pd
from scholarly import scholarly as sc

app = Flask(__name__)

@app.route('/')
def home():
    return render_template('index.html')

@app.route('/search', methods=['POST'])
def search_author():
    input_author = request.form.get('author_name')
    authors = list(sc.search_author(input_author))

    authors_data = [
        {"index": i+1, "name": author['name'], "affiliation": author.get('affiliation', 'N/A')}
        for i, author in enumerate(authors)
    ]

    return render_template('select.html', authors=authors_data, input_author=input_author)

# @app.route('/select', methods=['POST'])
# def select_author():
#     input_author = request.form.get('input_author')
#     selection = int(request.form.get('selected_author')) - 1
#     authors = list(sc.search_author(input_author))
#
#     selected_author = authors[selection]
#     author_info = sc.fill(selected_author)
#
#     author_data = {
#         'Author Name': author_info['name'],
#         'Affiliation': author_info.get('affiliation', 'N/A'),
#         'Citations': author_info['citedby'],
#         'Homepage': author_info.get('url_picture', 'N/A'),
#         'Total Publications': author_info.get('num_publications', 'N/A'),
#     }
#
#     publications_list = [
#         {
#             "title": publication['bib'].get('title', 'N/A'),
#             "year": publication['bib'].get('pub_year', 'N/A'),
#             "citations": publication.get('num_citations', 0),
#         }
#         for publication in author_info.get('publications', [])
#     ]
#
#     df = pd.DataFrame(publications_list)
#     author_summary = pd.DataFrame([author_data])
#
#     combined_df = pd.concat([author_summary, df], ignore_index=True)
#     output_path = "output.xlsx"
#     combined_df.to_excel(output_path, index=False)
#
#     return send_file(output_path, as_attachment=True)

@app.route('/select', methods=['POST'])
def select_author():
    input_author = request.form.get('input_author')
    selected_authors = request.form.getlist('selected_author')      
    authors = list(sc.search_author(input_author))

    all_author_data = []

    for selection in selected_authors:
        selection_index = int(selection) - 1
        selected_author = authors[selection_index]
        author_info = sc.fill(selected_author)

        author_data = {
            'Author Name': author_info['name'],
            'Affiliation': author_info.get('affiliation', 'N/A'),
            'Citations': author_info['citedby'],
            'Homepage': author_info.get('url_picture', 'N/A'),
            'Total Publications': author_info.get('num_publications', 'N/A'),
        }

        publications_list = [
            {
                "title": publication['bib'].get('title', 'N/A'),
                "year": publication['bib'].get('pub_year', 'N/A'),
                "citations": publication.get('num_citations', 0),
            }
            for publication in author_info.get('publications', [])
        ]
        
        df = pd.DataFrame(publications_list)
        author_summary = pd.DataFrame([author_data])

        combined_df = pd.concat([author_summary, df], ignore_index=True)
        all_author_data.append(combined_df)

    final_df = pd.concat(all_author_data, ignore_index=True)

    output_path = "output_multiple_authors.xlsx"
    final_df.to_excel(output_path, index=False)

    return send_file(output_path, as_attachment=True)

if __name__ == "__main__":
    app.run(debug=True)
