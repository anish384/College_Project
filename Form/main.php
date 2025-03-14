<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awards Submission</title>
    <style>
        /* Reset body and layout styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            background-color: rgb(238, 235, 240);
            height: 40px;
            width: auto;
            display: flex;
            flex-direction: row;
            justify-content: start;
            margin: 0;
            padding: 0;
        }

        .real {
            background-color: white;
            color: white;
            padding: 0;
            text-align: center;
            height: auto;
            width: auto;
            margin: 0;

        }

        .row {
            background-color: rgb(238, 235, 240);
            color: rgb(29, 28, 28);
            height: 50%;
            width: 20%;
            margin-right: 60%;
            margin-top: 10px;
            margin-left: 10px;
        }

        .container1 {
            background-color: rgb(255, 255, 255);
            color: rgb(43, 69, 152);
            height: 120px;
            width: auto;
            position: sticky;
        }

        .row1 {
            background-color: rgb(255, 255, 255);
            align-items: center;
            justify-content: space-between;
            text-align: center;
            display: flex;
            flex-direction: row;
            width: 80%;
            margin-left: 10%;
            
        }

        .site_header_1 {
            height: 100px;
            width: 100px;

        }
        
        .photo {
            height: 100%;
            width: 100%;
            margin-top: 2px;
        }

        /* Form Styling */

        h1 {
            text-align: center;
            font-size: 2rem;
            color: rgb(24, 95, 177);
        }

        form {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #d7d1d1;
            color: black;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        table {
            width: 100%;
            margin: 20px 0;
        }

        table td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        table label {
            font-size: 1rem;
            font-weight: bold;
            display: block;
        }

        table input[type="text"],
        table input[type="number"],
        table input[type="date"],
        table input[type="email"],
        table input[type="file"],
        select,
        table textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #555;
            border-radius: 4px;
            background:#ebebeb;
            color:#181717;
            font-size: 1rem;
        }

        textarea {
            resize: none;
        }

        table input[type="number"] {
            -moz-appearance: textfield;
        }

        table button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        table button:hover {
            background-color: #45a049;
        }

        /* Dynamic Form Containers */
        .form-container {
            margin-bottom: 10px;
            padding: 15px;
            background-color: #f1ecec;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .form-container label {
            display: inline-block;
            font-weight: bold;
            margin-bottom: 4px;
            color: black;
        }

        .form-container input[type="number"] {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 6px;
            font-size: 1rem;
        }

        .form-container button {
            padding: 12px;
            font-size: 1rem;
            background-color: #3498db;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            color: white;
            transition: background-color 0.3s ease;
        }


        .form-container button:hover {
            background-color: #2980b9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container1 {
                flex-direction: column;
                text-align: center;
            }

            .photo {
                margin-bottom: 15px;
            }

            .row1{
                font-size: 1.2rem;
            }

            form {
                width: 95%;
            }

            .form-container {
                width: 100%;
            }
        }

        footer {
         background-color: rgb(43, 69, 152);
         color: rgb(255, 255, 255);
         text-align: center;
         padding: 10px 20px;
         bottom: 0;
         width: 100%;
          position: relative;
        }
    </style>


</head>

<body>

    <div class="real">
        <div class="container">

            <div class="row">
                <div class="site_topbar">
                    <i class="phone"></i> <b>0831-2438100/123</b>
                    <i class="envelope_icon"></i> info@aitmbgm.ac.in
                </div>

            </div>


        </div>
    </div>

    <div class="container1">

<div class="row1">

    <div class="site_header_1">
        <h2 class="web_title">
            <a class="back" href="https://aitmbgm.ac.in">
                <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/Suresh-Angadi.jpg"
                    alt="AITMBGM" title="AITMBGM">
            </a>
        </h2>
    </div>

    <div class="site_header_2">
        <h2 class="web_title ">
            <a class="back" href="https://aitmbgm.ac.in">
                <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitmbgm-logo.png"
                    alt="AITMBGM" title="AITMBGM">
            </a>
        </h2>
    </div>

    <div class="site_header_3">
        <h6>SURESH ANGADI EDUCATION FOUNDATIONS</h6>
        <h2>ANGADI INSTITUTE OF TECHNOLOGY AND MANAGEMENT</h2>
        <span>Approved by AICTE, New Delhi, Affiliated to VTU, Belagavi. <br>Accredited by *NBA and
            NAAC<br></span>
    </div>

    <div class="site_header_4 ">
        <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitm-logo.png" alt="AITM"
            title="AITM">
    </div>
</div>

</div>


    <div class="form-container">
        <h1>Information</h1>
        <form action="phpCode/faculty.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><label for="faculty_id">Faculty ID: </label></td>
                    <td><input type="text" id="faculty_id" name="faculty_id"></td>
                </tr>
                <tr>
                    <td><label for="name">Name: </label></td>
                    <td><input type="text" id="name" name="name"></td>
                </tr>
                <tr>
                    <td><label for="Designation">Designation</label></td>
                    <td><input type="text" id="Designation" name="Designation"></td>
                </tr>
                <tr>
                    <td><label for="Department">Department</label></td>
                    <td><select id="Department" name="Department">
                            <option value="NULL">Select</option>
                            <option value="Artificial Intelligence & Data Science">Artificial Intelligence & Data
                                Science</option>
                            <option value="Chemistry">Chemistry</option>
                            <option value="Civil Engineering">Civil Engineering</option>
                            <option value="Computer Science & Engineering">Computer Science & Engineering</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Electrical & Electronic Engineering">Electrical & Electronic Engineering
                            </option>
                            <option value="Electronics & Communication Engineering">Electronics & Communication
                                Engineering</option>
                            <option value="M.Tech(Civil)">M.Tech(Civil)</option>
                            <option value="M.Tech(Mechanical)">M.Tech(Mechanical)</option>
                            <option value="Mathematics">Mathematics</option>
                            <option value="MBA">MBA</option>
                            <option value="MCA">MCA</option>
                            <option value="Mechanical Engineering">Mechanical Engineering</option>
                            <option value="Physics">Physics</option>
                            <option value="Robotics & Automation">Robotics & Automation</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="date_of_joining">Date of Joining: </label></td>
                    <td><input type="date" id="date_of_joining" name="date_of_joining"></td>
                </tr>
                <tr>
                    <td><label for="email">Email: </label></td>
                    <td><input type="email" id="email" name="email"></td>
                </tr>
                <tr>
                    <td><label for="con">Contact No: </label></td>
                    <td><input type="number" id="con" name="con"></td>
                </tr>
                <tr>
                    <td><label for="orchid_id">Orchid ID: </label></td>
                    <td><input type="text" id="orchid_id" name="orchid_id"></td>
                </tr>
                <tr>
                    <td><label for="scholar">Google Scholar: </label></td>
                    <td><input type="text" id="scholar" name="scholar"></td>
                </tr>
                <tr>
                    <td><label for="img">Image: </label></td>
                    <td><input type="file" id="img" name="img"></td>
                </tr>
                
                <tr>
                    <td colspan="2"><button>Submit</button></td>
                </tr>
            </table>
        </form>
    </div>

    <div class="form-container">
        <h1>Awards</h1>
        <label for="numAwards">Number of Awards:</label>
        <input type="number" id="numAwards" placeholder="Enter number of awards">
        <button type="button" onclick="generateAwardForms()">Generate Awards Forms</button>
        <form action="phpCode/awards.php" method="post" id="dynamicAwardsForm" onsubmit="submitForm(event)">
            <div id="awardFormsContainer"></div>
            <button type="submit">Submit All Awards</button>
        </form>
    </div>


    <div class="form-container">
        <h1>Books Submission</h1>
        <div>
            <label for="numBooks">Number of Books:</label>
            <input type="number" id="numBooks" placeholder="Enter number of books">
            <button type="button" onclick="generateBookForms()">Generate Book Forms</button>
        </div>
        <form action="phpCode/books.php" method="post" id="dynamicBooksForm" onsubmit="submitForm(event)">
            <div id="bookFormsContainer"></div>
            <button type="submit">Submit All Books</button>
        </form>
    </div>

    <div class="form-container">
        <h1>Chair/Resource Submission</h1>
        <div>
            <label for="numResources">Number of Chair/Resources:</label>
            <input type="number" id="numResources" placeholder="Enter number of entries">
            <button type="button" onclick="generateChairResourceForms()">Generate Chair/Resource Forms</button>
        </div>
        <form action="phpCode/chair_resource.php" method="post" id="dynamicChairResourceForm" onsubmit="submitForm(event)">
            <div id="chairResourceFormsContainer"></div>
            <button type="submit">Submit All Chair/Resources</button>
        </form>
    </div>

    <div class="form-container">
        <h1>Conference Submission</h1>
        <div>
            <label for="numConferences">Number of Conferences:</label>
            <input type="number" id="numConferences" placeholder="Enter number of entries">
            <button type="button" onclick="generateConferenceForms()">Generate Conference Forms</button>
        </div>
        <form action="phpCode/conference.php" method="post" id="dynamicConferenceForm"   onsubmit="submitForm(event)">
            <div id="conferenceFormsContainer"></div>
            <button type="submit">Submit All Conferences</button>
        </form>
    </div>


    <div class="form-container">
        <h1>Experience Form</h1>
        <div>
            <label for="numExperiences">Number of Experience Entries:</label>
            <input type="number" id="numExperiences" placeholder="Enter number of entries">
            <button type="button" onclick="generateExperienceForms()">Generate Experience Forms</button>
        </div>
        <form action="phpCode/experience.php" method="post" id="dynamicExperienceForm"  onsubmit="submitForm(event)">
            <div id="experienceFormsContainer"></div>
            <button type="submit">Submit All Experiences</button>
        </form>
    </div>

    <div class="form-container">
        <h1>Conference Form</h1>
        <div>
            <label for="numConferencesAttended">Number of Conferences:</label>
            <input type="number" id="numConferencesAttended" placeholder="Enter number of conferences">
            <button type="button" onclick="generateConferenceAttendedForms()">Generate Conference Forms</button>
        </div>
        <form action="phpCode/conference_Attended.php" method="post" id="dynamicConferenceForm" onsubmit="submitForm(event)">
            <div id="conferenceAttendedFormsContainer"></div>
            <button type="submit">Submit All Conferences</button>
        </form>
    </div>

    <div class="form-container">
        <h1>Scholars Form</h1>
        <div>
            <label for="numScholars">Number of Scholars:</label>
            <input type="number" id="numScholars" placeholder="Enter number of scholars">
            <button type="button" onclick="generateScholarsForms()">Generate Scholars Forms</button>
        </div>
        <form action="phpCode/for_scholars.php" method="post" id="dynamicScholarsForm" onsubmit="submitForm(event)" >
            <div id="scholarsFormsContainer"></div>
            <button type="submit">Submit All Scholars</button>
        </form>
    </div>
    <div class="form-container">

        <h1>Journals Form</h1>

        <div>

            <label for="numJournals">Number of Journals:</label>

            <input type="number" id="numJournals" placeholder="Enter number of journals">

            <button type="button" onclick="generateJournalForms()">Generate Journal Forms</button>

        </div>

        <form action="phpCode/journals.php" method="post" id="dynamicJournalsForm"  onsubmit="submitForm(event)">

            <div id="journalsFormsContainer"></div>

            <button type="submit">Submit All Journals</button>

        </form>

    </div>



    <div class="form-container">
        <h1>Mtech Form</h1>
        <div>
            <label for="numMtechGuided">Number of Journals:</label>
            <input type="number" id="numMtechGuided" placeholder="Enter number of journals" min="1">
            <button type="button" onclick="generateMtechGuidedForms()">Generate Journal Forms</button>
        </div>

        <form action="phpCode/mtech_guided.php" method="post" id="dynamicJournalForm"  onsubmit="submitForm(event)">
            <div id="MtechGuidedContainer"></div>
            <button type="submit">Submit All Mtech Guided</button>
        </form>
    </div>

    <div class="form-container">

        <h1>Patent Form</h1>

        <div>

            <label for="numPatent">Number of Patents:</label>

            <input type="number" id="numPatent" placeholder="Enter number of patents" min="1">

            <button type="button" onclick="generatePatentsForms()">Generate Patent Forms</button>

        </div>



        <form action="phpCode/patents.php" method="post" id="dynamicPatentForm" onsubmit="submitForm(event)">

            <div id="PatentContainer"></div>

            <button type="submit">Submit All Patents</button>

        </form>

    </div>

    <div class="form-container">
        <h1>Certification Form</h1>
        <div>
            <label for="numCertificates">Number of Certificates:</label>
            <input type="number" id="numCertificates" placeholder="Enter number of certificates" min="1">
            <button type="button" onclick="generateCertificatesForms()">Generate Certification Forms</button>
        </div>

        <form action="phpCode/certificate.php" method="post" id="dynamicCertificateForm" onsubmit="submitForm(event)">
            <div id="certificateContainer"></div>
            <button type="submit">Submit All Certificates</button>
        </form>
    </div>

    <div class="form-container">
        <h1>PhD Guided Form </h1>
        <div>
            <label for="numPhdGuided">Number of PhD Guided:</label>
            <input type="number" id="numPhdGuided" placeholder="Enter number of PhD guided" min="1">
            <button type="button" onclick="generatePhdGuidedForms()">Generate PhD Guided Forms</button>
        </div>

        <form action="phpCode/phd_guided.php" method="post" id="dynamicPhdGuidedForm"  onsubmit="submitForm(event)">
            <div id="PhdGuidedContainer"></div>
            <button type="submit">Submit All PhD Guided</button>
        </form>
    </div>


    <div class="form-container">
        <h1>Organization Form</h1>
        <div>
            <label for="numOrganizations">Number of Organizations:</label>
            <input type="number" id="numOrganizations" placeholder="Enter number of organizations" min="1">
            <button type="button" onclick="generateOrganizationForms()">Generate Organization Forms</button>
        </div>

        <form action="phpCode/organization.php" method="post" id="dynamicOrganizationForm" onsubmit="submitForm(event)">
            <div id="OrganizationContainer"></div>
            <button type="submit">Submit All Organizations</button>
        </form>
    </div>


    <div class="form-container">
        <h1>Education Form</h1>
        <div>
            <label for="numEducation">Number of Education Records:</label>
            <input type="number" id="numEducation" placeholder="Enter number of records" min="1">
            <button type="button" onclick="generateEducationForms()">Generate Education Forms</button>
        </div>

        <form action="phpCode/education.php" method="post" id="dynamicEducationForm" onsubmit="submitForm(event)">
            <div id="EducationContainer"></div>
            <button type="submit">Submit All Education Records</button>
        </form>
    </div>


    <div class="form-container">
        <h1>Research Project Form</h1>
        <div>
            <label for="numResearch">Number of Research Projects:</label>
            <input type="number" id="numResearch" placeholder="Enter number of research projects" min="1">
            <button type="button" onclick="generateResearchForms()">Generate Research Forms</button>
        </div>

        <form action="phpCode/research.php" method="post" id="dynamicResearchForm"  onsubmit="submitForm(event)">
            <div id="ResearchContainer"></div>
            <button type="submit">Submit All Research Projects</button>
        </form>
    </div>


    <div class="form-container">
        <h1>Funding Scheme Form</h1>
        <div>
            <label for="numFunding">Number of Funding Schemes:</label>
            <input type="number" id="numFunding" placeholder="Enter number of funding schemes" min="1">
            <button type="button" onclick="generateFundingForms()">Generate Funding Forms</button>
        </div>

        <form action="phpCode/funding.php" method="post" id="dynamicFundingForm" onsubmit="submitForm(event)">
            <div id="FundingContainer"></div>
            <button type="submit">Submit All Funding Schemes</button>
        </form>
    </div>


    <div class="form-container">
        <h1>Project Form</h1>
        <div>
            <label for="numProjects">Number of Projects:</label>
            <input type="number" id="numProjects" placeholder="Enter number of projects" min="1">
            <button type="button" onclick="generateProjectForms()">Generate Project Forms</button>
        </div>

        <form action="phpCode/projects.php" method="post" id="dynamicProjectForm" onsubmit="submitForm(event)">
            <div id="ProjectContainer"></div>
            <button type="submit">Submit All Projects</button>
        </form>
    </div>

    <div class="form-container">
        <h1>Others</h1>
        <div>
            <label for="numProjects">Other:</label>
            <input type="number" id="other" placeholder="" min="1">
            <button type="button" onclick="generateOtherForms()">Generate Forms</button>
        </div>

        <form action="phpCode/others.php" method="post" id="dynamicOtherForm" onsubmit="submitForm(event)">
            <div id="OtherContainer"></div>
            <button type="submit">Submit</button>
        </form>
    </div>

<div id="commonSuccessMessage" style="display: none; color: green; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #4CAF50; color: white; padding: 20px 30px; border-radius: 5px; font-size: 18px; font-weight: bold; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); z-index: 1000;">
    Submitted successfully!
</div>

    <footer>
        <h2>Angadi Insitute Of Technology And Management</h2>
    </footer>

    


    <script>

function submitForm(event) {
    event.preventDefault();

    // Create a FormData object from the form
    var formData = new FormData(event.target);

    // Send the form data to the PHP script using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", event.target.action, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // If the request was successful, show the success message
            const successMessage = document.getElementById('commonSuccessMessage');
            successMessage.style.display = "block";

            // Hide the success message after 3 seconds
            setTimeout(function () {
                successMessage.style.display = "none";
            }, 3000);
        }
    };

    xhr.send(formData);
}


        function generateAwardForms() {
            const numAwards = document.getElementById("numAwards").value;
            const container = document.getElementById("awardFormsContainer");
            const facultyID = document.getElementById("faculty_id").value;

            // Clear existing forms
            container.innerHTML = "";

            // Generate the required number of award forms
            for (let i = 1; i <= numAwards; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
            <h3>Award ${i}</h3>
                            <table>
                                <tr>
                                    <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                                    <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}"></td>
                                </tr>
                                <tr>
                                    <td><label for="name_of_awards_${i}">Name of Awards: </label></td>
                                    <td><input type="text" id="name_of_awards_${i}" name="name_of_awards_${i}"></td>
                                </tr>
                                <tr>
                                    <td><label for="Organizer_${i}">Organizer: </label></td>
                                    <td><input type="text" id="Organizer_${i}" name="Organizer_${i}"></td>
                                </tr>
                                <tr>
                                    <td><label for="Place_${i}">Place: </label></td>
                                    <td><input type="text" id="Place_${i}" name="Place_${i}"></td>
                                </tr>
                                <tr>
                                    <td><label for="year_${i}">Year: </label></td>
                                    <td><input type="number" id="year_${i}" name="year_${i}"></td>
                                </tr>
                            </table>
                        `;
                container.appendChild(formSet);
            }

        }

        function generateBookForms() {
            const numBooks = document.getElementById("numBooks").value;
            const container = document.getElementById("bookFormsContainer");
            const facultyID = document.getElementById("faculty_id").value;

            // Clear existing forms
            container.innerHTML = "";

            // Generate the required number of book forms
            for (let i = 1; i <= numBooks; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                            <h3>Book ${i}</h3>
                            <table>
                                <tr>
                                    <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                                    <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}"></td>
                                </tr>
                                <tr>
                                    <td><label for="Title_${i}">Title: </label></td>
                                    <td><textarea name="Title_${i}" id="Title_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="Publisher_${i}">Publisher: </label></td>
                                    <td><textarea name="Publisher_${i}" id="Publisher_${i}" cols="50" rows="4" maxlength="255"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="Place_${i}">Place: </label></td>
                                    <td><textarea name="Place_${i}" id="Place_${i}" cols="50" rows="4" maxlength="255"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="YOP_${i}">Year Of Publication: </label></td>
                                    <td><input type="number" id="YOP_${i}" name="YOP_${i}"></td>
                                </tr>
                                <tr>
                                    <td><label for="isbn_${i}">ISBN: </label></td>
                                    <td><input type="text" id="isbn_${i}" name="isbn_${i}"></td>
                                </tr>
                                <tr>
                                    <td><label for="book_chapter_${i}">Book/Chapter</label></td>
                                    <td>
                                        <select name="book_chapter_${i}" id="book_chapter_${i}">
                                            <option value="">Select Type</option>
                                            <option value="Book">Book</option>
                                            <option value="Chapter">Chapter</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="link_${i}">Link: </label></td>
                                    <td><input type="text" id="link_${i}" name="link_${i}"></td>
                                </tr>
                            </table>
                        `;
                container.appendChild(formSet);
            }
        }

        function generateChairResourceForms() {
            const numResources = document.getElementById("numResources").value;
            const container = document.getElementById("chairResourceFormsContainer");
            const facultyID = document.getElementById("faculty_id").value;

            // Clear existing forms
            container.innerHTML = "";

            // Generate the required number of chair/resource forms
            for (let i = 1; i <= numResources; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                            <h3>Chair/Resource ${i}</h3>
                            <table>
                                <tr>
                                    <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                                    <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}"></td>
                                </tr>
                                <tr>
                                    <td><label for="Organization_${i}">Organization: </label></td>
                                    <td><textarea name="Organization_${i}" id="Organization_${i}" cols="50" rows="4" maxlength="255"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="Chair_resource_${i}">Chair Resource: </label></td>
                                    <td><textarea name="Chair_resource_${i}" id="Chair_resource_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="Place_${i}">Place: </label></td>
                                    <td><textarea name="Place_${i}" id="Place_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="year_chair_resource_${i}">Year: </label></td>
                                    <td><input type="number" id="year_chair_resource_${i}" name="year_chair_resource_${i}"></td>
                                </tr>
                            </table>
                        `;
                container.appendChild(formSet);
            }
        }


        function generateConferenceForms() {
            const numConferences = document.getElementById("numConferences").value;
            const container = document.getElementById("conferenceFormsContainer");
            const facultyID = document.getElementById("faculty_id").value;

            // Clear existing forms
            container.innerHTML = "";

            // Generate the required number of conference forms
            for (let i = 1; i <= numConferences; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                            <h3>Conference ${i}</h3>
                            <table>
                                <tr>
                                    <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                                    <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}"></td>
                                </tr>
                                <tr>
                                    <td><label for="Title_${i}">Title: </label></td>
                                    <td><textarea name="Title_${i}" id="Title_${i}" cols="50" rows="4" required></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="Name_of_conf_${i}">Name of the Conference: </label></td>
                                    <td><textarea name="Name_of_conf_${i}" id="Name_of_conf_${i}" cols="50" rows="4" required></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="int_nat_${i}">International/National: </label></td>
                                    <td>
                                        <select name="int_nat_${i}" id="int_nat_${i}" required>
                                            <option value="national">National</option>
                                            <option value="international">International</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="publisher_${i}">Publisher: </label></td>
                                    <td><input type="text" name="publisher_${i}" id="publisher_${i}" value="" cols="50" rows="4" required></td>
                                </tr>
                                <tr>
                                    <td><label for="place_${i}">Place</label></td>
                                    <td><textarea name="place_${i}" id="place_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="year_${i}">Year </label></td>
                                    <td><input type="number" id="year_${i}" name="year_${i}" required></td>
                                </tr>
                                <tr>
                                    <td><label for="website_link_${i}">Website Link: </label></td>
                                    <td><input type="url" name="website_link_${i}" id="website_link_${i}" value="" cols="50" rows="4" required></td>
                                </tr>
                                <tr>
                                    <td><label for="author_type_${i}">Author Type: </label></td>
                                    <td>
                                        <select name="author_type_${i}" id="author_type_${i}" required>
                                            <option value="first_author">First Author</option>
                                            <option value="co-author">Co-Author</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="remarks_${i}">Remarks: </label></td>
                                    <td><textarea name="remarks_${i}" id="remarks_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                            </table>
                        `;
                container.appendChild(formSet);
            }
        }


        function generateExperienceForms() {
            const numExperiences = document.getElementById("numExperiences").value;
            const container = document.getElementById("experienceFormsContainer");
            const facultyID = document.getElementById("faculty_id").value;

            container.innerHTML = "";

            for (let i = 1; i <= numExperiences; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                            <h3>Experience ${i}</h3>
                            <table>
                                <tr>
                                    <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                                    <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}"></td>
                                </tr>
                                <tr>
                                    <td><label for="industry_${i}">Industry</label></td>
                                    <td><textarea name="industry_${i}" id="industry_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="teaching_${i}">Teaching</label></td>
                                    <td><textarea name="teaching_${i}" id="teaching_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="research_${i}">Research</label></td>
                                    <td><textarea name="research_${i}" id="research_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                            </table>
                        `;
                container.appendChild(formSet);
            }
        }

        function generateConferenceAttendedForms() {
            const numConferences = document.getElementById("numConferencesAttended").value;
            const container = document.getElementById("conferenceAttendedFormsContainer");
            const facultyID = document.getElementById("faculty_id").value;

            // Clear existing forms
            container.innerHTML = "";

            // Generate forms dynamically
            for (let i = 1; i <= numConferences; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                            <h3>Conference ${i}</h3>
                            <table>
                                <tr>
                                    <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                                    <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}"></td>
                                </tr>
                                <tr>
                                    <td><label for="topic_${i}">Topic</label></td>
                                    <td><textarea name="topic_${i}" id="topic_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="organizer_${i}">Organizer</label></td>
                                    <td><textarea name="organizer_${i}" id="organizer_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="noofdays_${i}">No of days</label></td>
                                    <td><input type="number" id="noofdays_${i}" name="noofdays_${i}"></td>
                                </tr>
                                <tr>
                                    <td><label for="place_${i}">Place</label></td>
                                    <td><textarea name="place_${i}" id="place_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="year_${i}">Year</label></td>
                                    <td><input type="number" id="year_${i}" name="year_${i}"></td>
                                </tr>
                            </table>
                        `;
                container.appendChild(formSet);
            }
        }

        function generateCertificatesForms() {
            const numCertificates = document.getElementById("numCertificates").value;
            const container = document.getElementById("certificateContainer");
            const facultyID = document.getElementById("faculty_id") ? document.getElementById("faculty_id").value : '';

            container.innerHTML = ""; // Clear any existing forms before generating new ones

            if (numCertificates < 1) {
                alert("Please enter a valid number of certificates.");
                return;
            }

            const currentYear = new Date().getFullYear();

            for (let i = 1; i <= numCertificates; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                    <h3>Certificate ${i}</h3>
                    <table>
                        <tr>
                            <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                            <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}" required></td>
                        </tr>
                        <tr>
                            <td><label for="certification_on_${i}">Certificate On: </label></td>
                            <td><input type="text" id="certification_on_${i}" name="certification_on_${i}" placeholder="Enter certificate topic/subject" required></td>
                        </tr>
                        <tr>
                            <td><label for="source_${i}">Source: </label></td>
                            <td><input type="text" id="source_${i}" name="source_${i}" placeholder="Enter certification provider" required></td>
                        </tr>
                        <tr>
                            <td><label for="year_${i}">Year: </label></td>
                            <td><input type="number" id="year_${i}" name="year_${i}" 
                                min="2000" max="${currentYear}" 
                                value="${currentYear}"
                                required></td>
                        </tr>
                    </table>
                    <hr>
                `;
                container.appendChild(formSet);
            }
        }

        // Add submit form function
        function submitForm(event) {
            event.preventDefault();
            const form = document.getElementById('dynamicCertificateForm');
            form.submit();
        }

        // Add the styling
        const style = document.createElement('style');
        style.textContent = `
            .form-container {
                margin-bottom: 20px;
                padding: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #f9f9f9;
            }
            .form-container h3 {
                color: #333;
                margin-top: 0;
            }
            .form-container table {
                width: 100%;
            }
            .form-container td {
                padding: 8px;
            }
            .form-container input[type="text"],
            .form-container input[type="number"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
                box-sizing: border-box;
            }
            hr {
                margin-top: 20px;
                border: 0;
                border-top: 1px solid #eee;
            }
            button {
                padding: 10px 20px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin: 10px 0;
            }
            button:hover {
                background-color: #45a049;
            }
        `;
        document.head.appendChild(style);

        function generateScholarsForms() {
            const numScholars = document.getElementById("numScholars").value;
            const container = document.getElementById("scholarsFormsContainer");
            const facultyID = document.getElementById("faculty_id").value;

            container.innerHTML = "";

            for (let i = 1; i <= numScholars; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                            <h3>Scholar ${i}</h3>
                            <table>
                                <tr>
                                    <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                                    <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}"></td>
                                </tr>
                                <tr>
                                    <td><label for="degree_${i}">Degree</label></td>
                                    <td><textarea name="degree_${i}" id="degree_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="University_${i}">University</label></td>
                                    <td><textarea name="University_${i}" id="University_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="yearofregi_${i}">Year of Registration</label></td>
                                    <td><input type="number" id="yearofregi_${i}" name="yearofregi_${i}"></td>
                                </tr>
                                <tr>
                                    <td><label for="areaofres_${i}">Area of Research</label></td>
                                    <td><textarea name="areaofres_${i}" id="areaofres_${i}" cols="50" rows="4"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="Year_of_complition_of_Coursework_${i}">Year of Completion of Coursework</label></td>
                                    <td><input type="number" id="Year_of_complition_of_Coursework_${i}" name="Year_of_complition_of_Coursework_${i}"></td>
                                </tr>
                                <tr>
                                    <td><label for="Year_of_complition_of_Comprehensive_${i}">Year of Completion of Comprehensive</label></td>
                                    <td><input type="number" id="Year_of_complition_of_Comprehensive_${i}" name="Year_of_complition_of_Comprehensive_${i}"></td>
                                </tr>
                                <tr>
                                    <td><label for="yearofpassing_${i}">Year of Passing</label></td>
                                    <td><input type="number" id="yearofpassing_${i}" name="yearofpassing_${i}"></td>
                                </tr>
                            </table>
                        `;
                container.appendChild(formSet);
            }
        }

        function generateJournalForms() {

            const numScholars = document.getElementById("numJournals").value;

            const container = document.getElementById("journalsFormsContainer");

            const facultyID = document.getElementById("faculty_id").value;



            container.innerHTML = "";



            for (let i = 1; i <= numScholars; i++) {

                const formSet = document.createElement("div");

                formSet.classList.add("form-container");

                formSet.innerHTML = `

        <h3>Journal ${i}</h3>

        <table>

        <tr>

        <td><label for="faculty_id_${i}">Faculty ID: </label></td>

        <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}"></td>

        </tr>

        <tr>

        <td><label for="title_${i}">Title</label></td>

        <td><textarea name="title_${i}" id="title_${i}" cols="50" rows="4"></textarea></td>

        </tr>

        <tr>

        <td><label for="name_of_journal_${i}">Name of Journal</label></td>

        <td><textarea name="name_of_journal_${i}" id="name_of_journal_${i}" cols="50" rows="4"></textarea></td>

        </tr>

        <tr>

        <td><label for="author_type_${i}">Author Type</label></td>

        <td>

        <select name="author_type_${i}" id="author_type_${i}">

        <option value="first-author">First Author</option>

        <option value="co-author">Co Author</option>

        </select>

        </td>

        </tr>

        <tr>

        <td><label for="publisher_${i}">Publisher</label></td>

        <td><textarea name="publisher_${i}" id="publisher_${i}" cols="50" rows="4"></textarea></td>

        </tr>

        <tr>

        <td><label for="place_${i}">Place</label></td>

        <td><input type="text" id="place_${i}" name="place_${i}"></td>

        </tr>

        <tr>

        <td><label for="vol_no_issue_no_${i}">Volume No / Issue No</label></td>

        <td><input type="text" id="vol_no_issue_no_${i}" name="vol_no_issue_no_${i}"></td>

        </tr>

        <tr>

        <td><label for="ISSN_${i}">ISSN</label></td>

        <td><input type="text" id="ISSN_${i}" name="ISSN_${i}"></td>

        </tr>

        <tr>

        <td><label for="page_no_${i}">Page No</label></td>

        <td><input type="text" id="page_no_${i}" name="page_no_${i}"></td>

        </tr>

        <tr>

        <td><label for="year_${i}">Year</label></td>

        <td><input type="number" id="year_${i}" name="year_${i}" min="1900" max="2100"></td>

        </tr>

        <tr>

        <td><label for="website_link_${i}">Website Link</label></td>

        <td><input type="url" id="website_link_${i}" name="website_link_${i}"></td>

        </tr>

        <tr>

        <td><label for="international_national_${i}">International / National</label></td>

        <td>

        <select name="international_national_${i}" id="international_national_${i}">

        <option value="international">International</option>

        <option value="national">National</option>

        </select>

        </td>

        </tr>

        <tr>

        <td><label for="free_paid_${i}">Free / Paid</label></td>

        <td>

        <select name="free_paid_${i}" id="free_paid_${i}">

        <option value="free">Free</option>

        <option value="paid">Paid</option>

        </select>

        </td>

        </tr>

        <tr>

        <td><label for="indexing_${i}">Indexing</label></td>

        <td><input type="text" id="indexing_${i}" name="indexing_${i}"></td>

        </tr>

        <tr>

        <td><label for="impact_factor_${i}">Impact Factor</label></td>

        <td><textarea name="impact_factor_${i}" id="impact_factor_${i}" cols="50" rows="4"></textarea></td>

        </tr>

        <tr>

        <td><label for="SNIP_${i}">SNIP</label></td>

        <td><input type="text" id="SNIP_${i}" name="SNIP_${i}"></td>

        </tr>

        <tr>

        <td><label for="SJR_${i}">SJR</label></td>

        <td><input type="text" id="SJR_${i}" name="SJR_${i}"></td>

        </tr>

        <tr>

        <td><label for="h_index_${i}">H-index</label></td>

        <td><input type="text" id="h_index_${i}" name="h_index_${i}"></td>

        </tr>

        <tr>

        <td><label for="citations_${i}">Citations</label></td>

        <td><input type="text" id="citations_${i}" name="citations_${i}"></td>

        </tr>

        </table>

`;
                container.appendChild(formSet);

            }
        }

        function generateMtechGuidedForms() {
            const numJournals = document.getElementById("numMtechGuided").value;
            const container = document.getElementById("MtechGuidedContainer");
            const facultyID = document.getElementById("faculty_id") ? document.getElementById("faculty_id").value : '';

            container.innerHTML = ""; // Clear any existing forms before generating new ones

            if (numJournals < 1) {
                alert("Please enter a valid number of journals.");
                return;
            }

            for (let i = 1; i <= numJournals; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                <h3>Journal ${i}</h3>
                <table>
                    <tr>
                        <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                        <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}" required></td>
                    </tr>
                    <tr>
                        <td><label for="year_${i}">Year: </label></td>
                        <td><input type="number" id="year_${i}" name="year_${i}" min="1900" max="2100" required></td>
                    </tr>
                    <tr>
                        <td><label for="college_or_university_${i}">College/University: </label></td>
                        <td><input type="text" id="college_or_university_${i}" name="college_or_university_${i}" required></td>
                    </tr>
                </table>
            `;
                container.appendChild(formSet);
            }
        }

        function generatePatentsForms() {
            const numJournals = document.getElementById("numPatent").value;
            const container = document.getElementById("PatentContainer");
            const facultyID = document.getElementById("faculty_id") ? document.getElementById("faculty_id").value : '';

            container.innerHTML = ""; // Clear any existing forms before generating new ones

            if (numJournals < 1) {
                alert("Please enter a valid number of journals.");
                return;
            }

            for (let i = 1; i <= numJournals; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                <h3>Journal ${i}</h3>
                <table>
                    <tr>
                        <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                        <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}" required></td>
                    </tr>
                    <tr>
                        <td><label for="title_${i}">Title: </label></td>
                        <td><textarea id="title_${i}" name="title_${i}" required></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="year_of_publication_${i}">Year of Publication: </label></td>
                        <td><input type="number" id="year_of_publication_${i}" name="year_of_publication_${i}" min="1900" max="2100" required></td>
                    </tr>
                    <tr>
                        <td><label for="status_${i}">Status: </label></td>
                        <td>
                            <select id="status_${i}" name="status_${i}" required>
                                <option value="">None</option>
                                <option value="Filed">Filed</option>
                                <option value="Granted">Granted</option>
                                <option value="Registered">Registered</option>
                                <option value="Published">Published</option>
                                
                            </select>
                        </td>
                    </tr>
                </table>
        `;
                container.appendChild(formSet);
            }
        }

        function generatePhdGuidedForms() {
            const numPatents = document.getElementById("numPhdGuided").value;
            const container = document.getElementById("PhdGuidedContainer");
            const facultyID = document.getElementById("faculty_id") ? document.getElementById("faculty_id").value : '';

            container.innerHTML = ""; // Clear any existing forms before generating new ones

            if (numPatents < 1) {
                alert("Please enter a valid number of patents.");
                return;
            }

            for (let i = 1; i <= numPatents; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                <h3>Patent ${i}</h3>
                <table>
                    <tr>
                        <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                        <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}" required></td>
                    </tr>
                    <tr>
                        <td><label for="year_${i}">Year: </label></td>
                        <td><input type="number" id="year_${i}" name="year_${i}" min="1900" max="2100" required></td>
                    </tr>
                    <tr>
                        <td><label for="college_or_university_${i}">College/University: </label></td>
                        <td><input type="text" id="college_or_university_${i}" name="college_or_university_${i}" required></td>
                    </tr>
                    <tr>
                        <td><label for="status_${i}">Status: </label></td>
                        <td>
                            <select id="status_${i}" name="status_${i}" required>
                                <option value="">None</option>
                                <option value="granted">Granted</option>
                                <option value="not-granted">Not granted</option>
                                
                            </select>
                        </td>
                    </tr>
                </table>
        `;
                container.appendChild(formSet);
            }
        }


        function generateOrganizationForms() {

            const numOrganizations = document.getElementById("numOrganizations").value;

            const container = document.getElementById("OrganizationContainer");

            const facultyID = document.getElementById("faculty_id") ? document.getElementById("faculty_id").value : '';



            container.innerHTML = ""; // Clear any existing forms before generating new ones



            if (numOrganizations < 1) {

                alert("Please enter a valid number of organizations.");

                return;

            }



            for (let i = 1; i <= numOrganizations; i++) {

                const formSet = document.createElement("div");

                formSet.classList.add("form-container");
                formSet.innerHTML = `

                <h3>Organization ${i}</h3>

                <table>

                    <tr>

                        <td><label for="faculty_id_${i}">Faculty ID: </label></td>

                        <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}" required></td>

                    </tr>

                    <tr>

                        <td><label for="organization_${i}">Organization: </label></td>

                        <td><input type="text" id="organization_${i}" name="organization_${i}" required></td>

                    </tr>

                    <tr>

                        <td><label for="member_category_${i}">Member Category: </label></td>

                        <td><input type="text" id="member_category_${i}" name="member_category_${i}" required></td>

                    </tr>

                    <tr>

                        <td><label for="since_${i}">Since: </label></td>

                        <td><input type="number" id="since_${i}" name="since_${i}" min="1900" max="2100" required></td>

                    </tr>

                </table>

        `;

                container.appendChild(formSet);

            }

        }



        function generateEducationForms() {
            const numEducations = document.getElementById("numEducation").value;
            const container = document.getElementById("EducationContainer");
            const facultyID = document.getElementById("faculty_id") ? document.getElementById("faculty_id").value : '';

            container.innerHTML = ""; // Clear any existing forms before generating new ones

            if (numEducations < 1) {
                alert("Please enter a valid number of education records.");
                return;
            }

            for (let i = 1; i <= numEducations; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                <h3>Education ${i}</h3>
                <table>
                    <tr>
                        <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                        <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}" required></td>
                    </tr>
                    <tr>
                        <td><label for="degree_${i}">Degree: </label></td>
                        <td>
                            <select id="degree_${i}" name="degree_${i}" required>
                                <option value="">None</option>
                                <option value="phd">PhD</option>
                                <option value="Mtech/ME">Mtech/ME</option>
                                <option value="BE/Btech">BE/Btech</option>
                                
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="university_${i}">University/Institution: </label></td>
                        <td><input type="text" id="university_${i}" name="university_${i}" required></td>
                    </tr>
                    <tr>
                        <td><label for="specialization_${i}">Specialization: </label></td>
                        <td><input type="text" id="specialization_${i}" name="specialization_${i}" required></td>
                    </tr>
                    <tr>
                        <td><label for="year_of_passing_${i}">Year of Passing: </label></td>
                        <td><input type="number" id="year_of_passing_${i}" name="year_of_passing_${i}" min="1900" max="2100" required></td>
                    </tr>
                </table>
        `;
                container.appendChild(formSet);
            }
        }

        function generateResearchForms() {
            const numResearch = document.getElementById("numResearch").value;
            const container = document.getElementById("ResearchContainer");
            const facultyID = document.getElementById("faculty_id") ? document.getElementById("faculty_id").value : '';

            container.innerHTML = ""; // Clear any existing forms before generating new ones

            if (numResearch < 1) {
                alert("Please enter a valid number of research projects.");
                return;
            }

            for (let i = 1; i <= numResearch; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                <h3>Research Project ${i}</h3>
                <table>
                    <tr>
                        <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                        <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}" required></td>
                    </tr>
                    <tr>
                        <td><label for="research_title_${i}">Research Title: </label></td>
                        <td><input type="text" id="research_title_${i}" name="research_title_${i}" required></td>
                    </tr>
                    <tr>
                        <td><label for="funding_organization_${i}">Funding Organization: </label></td>
                        <td><input type="text" id="funding_organization_${i}" name="funding_organization_${i}" required></td>
                    </tr>
                    <tr>
                        <td><label for="amount_${i}">Amount: </label></td>
                        <td><input type="text" id="amount_${i}" name="amount_${i}" required></td>
                    </tr>
                    <tr>
                        <td><label for="year_${i}">Year: </label></td>
                        <td><input type="number" id="year_${i}" name="year_${i}" min="1900" max="2100" required></td>
                    </tr>
                </table>
        `;
                container.appendChild(formSet);
            }
        }



        function generateFundingForms() {
            const numFunding = document.getElementById("numFunding").value;
            const container = document.getElementById("FundingContainer");
            const facultyID = document.getElementById("faculty_id") ? document.getElementById("faculty_id").value : '';

            container.innerHTML = ""; // Clear any existing forms before generating new ones

            if (numFunding < 1) {
                alert("Please enter a valid number of funding schemes.");
                return;
            }

            for (let i = 1; i <= numFunding; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                <h3>Funding Scheme ${i}</h3>
                <table>
                    <tr>
                        <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                        <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}" required></td>
                    </tr>
                    <tr>
                        <td><label for="title_${i}">Title: </label></td>
                        <td><textarea id="title_${i}" name="title_${i}" required></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="scheme_${i}">Scheme: </label></td>
                        <td><input type="text" id="scheme_${i}" name="scheme_${i}" required></td>
                    </tr>
                    <tr>
                        <td><label for="funding_organization_${i}">Funding Organization: </label></td>
                        <td><input type="text" id="funding_organization_${i}" name="funding_organization_${i}" required></td>
                    </tr>
                    <tr>
                        <td><label for="amount_${i}">Amount: </label></td>
                        <td><input type="text" id="amount_${i}" name="amount_${i}" required></td>
                    </tr>
                    <tr>
                        <td><label for="year_${i}">Year: </label></td>
                        <td><input type="number" id="year_${i}" name="year_${i}" min="1900" max="2100" required></td>
                    </tr>
                    <tr>
                        <td><label for="status_${i}">Status: </label></td>
                        <td>
                            <select id="status_${i}" name="status_${i}" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="">None</option>
                            </select>
                        </td>
                    </tr>
                </table>
        `;
                container.appendChild(formSet);
            }
        }

        function generateProjectForms() {
            const numProjects = document.getElementById("numProjects").value;
            const container = document.getElementById("ProjectContainer");
            const facultyID = document.getElementById("faculty_id") ? document.getElementById("faculty_id").value : '';

            container.innerHTML = ""; // Clear any existing forms before generating new ones

            if (numProjects < 1) {
                alert("Please enter a valid number of projects.");
                return;
            }

            for (let i = 1; i <= numProjects; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
                <h3>Project ${i}</h3>
                <table>
                    <tr>
                        <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                        <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}" required></td>
                    </tr>
                    <tr>
                        <td><label for="title_${i}">Title: </label></td>
                        <td><textarea id="title_${i}" name="title_${i}" required></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="name_of_leader_${i}">Name of Leader: </label></td>
                        <td><input type="text" id="name_of_leader_${i}" name="name_of_leader_${i}" required></td>
                    </tr>
                    <tr>
                        <td><label for="sponsoring_organization_${i}">Sponsoring Organization: </label></td>
                        <td><textarea id="sponsoring_organization_${i}" name="sponsoring_organization_${i}" required></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="amount_${i}">Amount: </label></td>
                        <td><input type="text" id="amount_${i}" name="amount_${i}" required></td>
                    </tr>
                    <tr>
                        <td><label for="year_${i}">Year: </label></td>
                        <td><input type="number" id="year_${i}" name="year_${i}" min="1900" max="2100" required></td>
                    </tr>
                </table>
        `;
                container.appendChild(formSet);
            }
        }

        function generateOtherForms() {
            const numProjects = document.getElementById("other").value;
            const container = document.getElementById("OtherContainer");
            const facultyID = document.getElementById("faculty_id") ? document.getElementById("faculty_id").value : '';

            container.innerHTML = ""; // Clear previous forms

            if (numProjects < 1) {
                alert("Please enter a valid number.");
                return;
            }

            for (let i = 1; i <= numProjects; i++) {
                const formSet = document.createElement("div");
                formSet.classList.add("form-container");
                formSet.innerHTML = `
            <h3>Entry ${i}</h3>
            <table>
                <tr>
                    <td><label for="faculty_id_${i}">Faculty ID: </label></td>
                    <td><input type="text" id="faculty_id_${i}" name="faculty_id_${i}" value="${facultyID}" required></td>
                </tr>
                <tr>
                    <td><label for="any_other_information_${i}">Any other information: </label></td>
                    <td><textarea id="any_other_information_${i}" name="any_other_information_${i}" required></textarea></td>
                </tr>
                <tr>
                    <td><label for="areas_of_interests_${i}">Areas of interests: </label></td>
                    <td><input type="text" id="areas_of_interests_${i}" name="areas_of_interests_${i}" required></td>
                </tr>
            </table>
        `;
                container.appendChild(formSet);
            }
        }
    </script>
</body>

</html>
