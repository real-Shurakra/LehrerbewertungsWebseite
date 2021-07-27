

export default class QuestionnaireStudents{

    constructor(questionnaire)
    {
        this.ShowQuestionnaire(questionnaire);
    }

    ShowQuestionnaire(questionnaire)
    {
        console.log("QuestionnaireStudents.ShowQuestionnaire");
        console.log(questionnaire);

        let response = questionnaire;

        let loginAreaStudents = document.getElementById("login_area_student");
        loginAreaStudents.innerHTL = "";

        let horizontalMenuButtonStudents = document.getElementById("horizontal_menu_button_students");
        
        horizontalMenuButtonStudents.style.backgroundColor = "#191f51"; // Marineblau
        horizontalMenuButtonStudents.style.color = "white";
        horizontalMenuButtonStudents.style.height = "47px";
        horizontalMenuButtonStudents.style.borderStyle = "none";
        horizontalMenuButtonStudents.style.width = "500px";

        let studentsQuestionnaireContainer = document.getElementById("students_questionnaire_container");
        studentsQuestionnaireContainer.style.opacity = "0.0";
        studentsQuestionnaireContainer.style.visibility = "hidden";

        // Input Values leeren
        let inputFieldsStudents = document.querySelectorAll(".input_student");			
        NodeList.prototype.forEach.call(inputFieldsStudents, function (el) {
            el.value = "";
        })

        // Container für Bogendaten-Tabelle
        let containerQuestionnaireTable = document.createElement("div");
        containerQuestionnaireTable.style.borderStyle = "solid";
        containerQuestionnaireTable.style.borderWidth = "1px";

        // Tabelle für Bogendaten
        let questionnaireTable = document.createElement("table");
        questionnaireTable.style.borderCollapse = "collapse";
        questionnaireTable.style.width = "100%";
        containerQuestionnaireTable.appendChild(questionnaireTable);

        // Bereich mit Begrüßungstext und Einleitung
        let introductionArea = document.createElement("div");
        introductionArea.style.width = "100%";
        introductionArea.style.textAlign = "left";
        introductionArea.style.paddingLeft = "10px";
        introductionArea.style.paddingRight = "10px";
        introductionArea.style.fontFamily = "calibri";
        {
            let xhttp = new XMLHttpRequest()
            xhttp.open("POST", "./html/introtext.htm", false);
            xhttp.send();
            introductionArea.innerHTML = xhttp.responseText;
        }
        containerQuestionnaireTable.appendChild(introductionArea);

        studentsQuestionnaireContainer.appendChild(containerQuestionnaireTable);
        //studentsQuestionnaireContainer.paddingTop = "1000px";
        studentsQuestionnaireContainer.style.overflowX = "hidden";

        let rowHeaders = document.createElement("tr");
        let rowData = document.createElement("tr");

        // Bogen-Header hinzufügen
        for (let index in response.returnvalue)
        {
            console.log(response.returnvalue[index]);
            let columnHeaders = document.createElement("td");
            columnHeaders.className = "questionnaireHeader";

            if (!(typeof response.returnvalue[index] === 'string')) continue;
            // Änderung der Header-Bezeichnungen
            if (index == "thema") 
            {
                columnHeaders.innerHTML = "Thema";
            }
            else if (index == "zeitstempel") columnHeaders.innerHTML = "Datum-Erstellung";
            else if (index == "id") continue;
            else if (index == "anzfragen") continue;
            else if (index == "schueleranzahl")
            {
                columnHeaders.innerHTML = "Schüleranzahl";
            }
            else if (index == "klassename")
            {
                columnHeaders.innerHTML = "Klasse";
            }
            else if (index == "fachname")
            {
                columnHeaders.innerHTML = "Fach";
            }
            else if (index == "bewertungsumme") columnHeaders.innerHTML = "Punkte";
            else columnHeaders.innerHTML = index;

            columnHeaders.style.backgroundColor = "#191f51"; // Marineblau
            columnHeaders.style.color = "white";
            columnHeaders.style.fontWeight = "bold";
            columnHeaders.style.fontSize = "medium";
            //columnHeaders.style.height = "25px";
            columnHeaders.style.padding = "5px";

            rowHeaders.appendChild(columnHeaders);

            let columnData = document.createElement("td");
            columnData.style.fontWeight = "bold";
            columnData.style.fontSize = "medium";
            //columnData.style.height = "25px";
            columnData.style.padding = "5px";

            if (index == "zeitstempel")
            {
                let timestamp = response.returnvalue[index].split(" ");
                columnData.innerHTML = timestamp[0];
            }
            else columnData.innerHTML = response.returnvalue[index];

            rowData.appendChild(columnData);			
        }
        questionnaireTable.appendChild(rowHeaders);
        questionnaireTable.appendChild(rowData);

        // Container für die Kategorien und Fragen
        let questionsContainer = document.createElement("div");
        questionsContainer.style.width = "100%";
        questionsContainer.style.overflowY = "auto";
        questionsContainer.style.scrollbarWidth = "none";
        questionsContainer.style.height = "95%"; // Grund für das Ermöglichen des Scrollens bis um Ende

        studentsQuestionnaireContainer.appendChild(questionsContainer);

        // Kategorien hinzufügen
        for (let element in response)
        {
            for (let dim2 in response[element])
            {
                if(response[element][dim2][0].fragestring != undefined && response[element][dim2][0].fragekategorie != undefined)
                {
                    // Kategorie-Header hinzufügen, Zusammengesetzte Id aus Fragebogen-Id und Kategorie-Id
                    let tempCategoryId = "students_questionnaire_category_" + response[element][dim2][0].fragekategorie;
                    let tempCategory = document.getElementById(tempCategoryId);

                    if (tempCategory == undefined) 
                    {
                        tempCategory = document.createElement("div");
                        tempCategory.id = tempCategoryId;

                        let tempCategoryTitle = document.createElement("div");
                        //tempCategoryTitle.style.height = "25px";
                        tempCategoryTitle.style.padding = "5px";
                        tempCategoryTitle.style.backgroundColor = "white";
                        tempCategoryTitle.style.backgroundColor = "#191f51"; // Marineblau
                        tempCategoryTitle.style.color = "white";
                        tempCategoryTitle.innerHTML = response[element][dim2][0].fragekategorie;
                        tempCategory.appendChild(tempCategoryTitle);

                        questionsContainer.appendChild(tempCategory);

                        let fillerDiv = document.createElement("div");
                        fillerDiv.style.height = "10px";

                        tempCategory.appendChild(fillerDiv);
                    }	
                }
            }
        }

        // Fragen den Kategorien hinzufügen
        for (let element in response)
        {
            for (let dim2 in response[element])
            {
                if(response[element][dim2][0].fragestring != undefined && response[element][dim2][0].fragekategorie != undefined)
                {
                    let tempQuestion = document.createElement("div");
                    tempQuestion.style.backgroundColor = "white";
                    tempQuestion.style.color = "black";
                    //tempQuestion.style.height = "40px";
                    tempQuestion.style.padding = "10px";
                    tempQuestion.style.verticalAlign = "center";
                    // Zusammengesetzte Id aus Fragebogen-Id und Frage-Id
                    tempQuestion.id = "students_questionnaire_question_" + response[element][dim2].frageid;
                    console.log(tempQuestion.id);

                    // --------------------------------------------------------------------------
                    // Tabelle erstellen und dem Div hinzufügen, Tabelle enthält die Frage sowie den Bereich um die Antwort zu geben
                    // tempQuestion.innerHTML = response[element][dim2][0].fragestring;
                    this.createFormTable(tempQuestion, response[element][dim2].frageid, response[element][dim2][0].fragestring);

                    // --------------------------------------------------------------------------

                    let tempCategory = document.getElementById("students_questionnaire_category_" + response[element][dim2][0].fragekategorie);
                    tempCategory.appendChild(tempQuestion);
                }
            }
         }

        // Fragebogen einblenden
        var timestamp = Math.floor(Date.now());
        let interval = setInterval(()=>{
            let tempTimestamp = Math.floor(Date.now());			
            studentsQuestionnaireContainer.style.opacity = ((tempTimestamp - timestamp) / 1000).toString();
            studentsQuestionnaireContainer.style.visibility = "visible";
            if(((tempTimestamp - timestamp) / 1000) >= 0.9) clearInterval(interval);
        },25);
    }

    createFormTable(motherDiv, questionId, question)
    {
        // Tabelle für Frage und Antwortmöglichkeiten
        let formTable = document.createElement("table");
        formTable.style.width = "100%";
        motherDiv.appendChild(formTable);

        let formTableRow = document.createElement("tr");
        formTable.appendChild(formTableRow);
        formTableRow.style.width = "100%";
        formTableRow.style.height = "100%";
        
        // Spalte für Frage
        let formTableColumQuestion = document.createElement("td");
        formTableRow.appendChild(formTableColumQuestion);
        formTableColumQuestion.innerHTML = question;
        formTableColumQuestion.style.width = "70%";
        formTableColumQuestion.style.fontSize = "22px";

        // Spalte für Antwortauswahl
        let formTableColumnAnswerSelection = document.createElement("td");
        formTableRow.appendChild(formTableColumnAnswerSelection);
        formTableColumnAnswerSelection.style.width = "30%";

    // -------------------------------------------------------------------------

        // Tabelle für Antwortmöglichkeiten
        let tableAnswerSelection = document.createElement("table");
        tableAnswerSelection.style.width = "100%";
        tableAnswerSelection.style.maxHeight = "40px";
        tableAnswerSelection.style.borderCollapse = "collapse";
        tableAnswerSelection.style.borderStyle = "solid";
        tableAnswerSelection.style.borderWidth = "1px";

        let rowAnswerSelection = document.createElement("tr");

        let AnswerValues = [];
        AnswerValues[0] = [];
        AnswerValues[0][0] = "+ +";
        AnswerValues[0][1] = 2;

        AnswerValues[1] = [];
        AnswerValues[1][0] = "+";
        AnswerValues[1][1] = 1;

        AnswerValues[2] = [];
        AnswerValues[2][0] = "o";
        AnswerValues[2][1] = 0;

        AnswerValues[3] = [];
        AnswerValues[3][0] = "-";
        AnswerValues[3][1] = -1;

        AnswerValues[4] = [];
        AnswerValues[4][0] = "- -";
        AnswerValues[4][1] = -2;

        for(let i = 0; i < AnswerValues.length; i++)
        {
            let tempColumn = document.createElement("td");
            tempColumn.style.width = "1%";
            if (i != 2) tempColumn.style.fontSize = "x-large";
            else tempColumn.style.fontSize = "large";
            tempColumn.style.textAlign = "center";
            tempColumn.style.fontWeight = "medium";
            tempColumn.style.borderStyle = "solid";
            tempColumn.style.borderWidth = "1px";
            tempColumn.style.cursor = "pointer";
            tempColumn.style.backgroundColor = "#ededed";//"#9eb3c7";
            tempColumn.id = questionId + "_" + AnswerValues[i][1];
            tempColumn.innerHTML = AnswerValues[i][0];;

            rowAnswerSelection.appendChild(tempColumn);
        }
        tableAnswerSelection.appendChild(rowAnswerSelection);

        // Tabelle zu Spalte für Antwortauswahl in Muttertabelle hinzufügen
        formTableColumnAnswerSelection.appendChild(tableAnswerSelection);
    }
}