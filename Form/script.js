function generateAwardForms() {
    const numAwards = document.getElementById("numAwards").value;
    const container = document.getElementById("awardFormsContainer");
    const facultyID = document.getElementById("faculty_id").value;

    // Clear existing forms
    container.innerHTML = "";

    // Generate the required number of award forms
    for (let i = 1; i <= numAwards; i++) {
        const formSet = document.createElement("div");
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
                            <td><textarea name="book_chapter_${i}" id="book_chapter_${i}" cols="50" rows="4" maxlength="255"></textarea></td>
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
        formSet.innerHTML = `
                    <h3>Conference ${i}</h3>
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
                            <td><label for="Name_of_conf_${i}">Name of the Conference</label></td>
                            <td><textarea name="Name_of_conf_${i}" id="Name_of_conf_${i}" cols="50" rows="4"></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="int_nat_${i}">International/National: </label></td>
                            <td>
                                <select name="int_nat_${i}" id="int_nat_${i}">
                                    <option value="int">International</option>
                                    <option value="nat">National</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="publisher_${i}">Publisher: </label></td>
                            <td><textarea name="publisher_${i}" id="publisher_${i}" cols="50" rows="4"></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="year_${i}">Year: </label></td>
                            <td><input type="number" id="year_${i}" name="year_${i}"></td>
                        </tr>
                        <tr>
                            <td><label for="website_link_${i}">Website Link: </label></td>
                            <td><textarea name="website_link_${i}" id="website_link_${i}" cols="50" rows="4"></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="author_type_${i}">Author Type: </label></td>
                            <td>
                                <select name="author_type_${i}" id="author_type_${i}">
                                    <option value="first_aut">First Author</option>
                                    <option value="co_aut">Co-Author</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="remarks_${i}">Remarks: </label></td>
                            <td><textarea name="remarks_${i}" id="remarks_${i}" cols="50" rows="8"></textarea></td>
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
                            <td><label for="Place_${i}">Place</label></td>
                            <td><textarea name="Place_${i}" id="Place_${i}" cols="50" rows="4"></textarea></td>
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
