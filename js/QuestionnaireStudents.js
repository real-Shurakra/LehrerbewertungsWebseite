

export default class QuestionnaireStudents{

    constructor(questionnaire)
    {
        this.answers = [];
        this.questionnaireId = undefined;
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

        //let studentsQuestionnaireContainer = document.getElementById("students_questionnaire_container");
        if (document.getElementById("students_questionnaire_container") != null) document.getElementById("students_questionnaire_container").remove();
        
            let studentsQuestionnaireContainer = document.createElement("div");
            document.body.appendChild(studentsQuestionnaireContainer);
            studentsQuestionnaireContainer.id = "students_questionnaire_container";
    
            studentsQuestionnaireContainer.style.opacity = "0.0";
            studentsQuestionnaireContainer.style.visibility = "hidden";

            studentsQuestionnaireContainer.style.height = window.innerHeight - 125 + "px";
            studentsQuestionnaireContainer.style.width = window.innerWidth - 500 + "px";
            studentsQuestionnaireContainer.style.borderStyle = "solid";
            studentsQuestionnaireContainer.style.borderColor = "#191f51"; // Marineblau
            studentsQuestionnaireContainer.style.borderWidth = "1px";
            studentsQuestionnaireContainer.style.top = "75px";
            studentsQuestionnaireContainer.style.left = "260px";
            studentsQuestionnaireContainer.style.padding = "10px";
            studentsQuestionnaireContainer.style.opacity = "93%";
    
    
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
            { // REM: Zurzeit kein Begrüßungstext in Datei
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
                else if (index == "bogenid")
                {
                    this.questionnaireId = response.returnvalue[index];
    
                    console.log("BogenId:");
                    console.log(this.questionnaireId);
                }
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
            questionsContainer.style.height = "91%"; // Grund für das Ermöglichen des Scrollens bis um Ende
    
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
                            tempCategoryTitle.style.padding = "1px";
                            tempCategoryTitle.style.backgroundColor = "white";
                            tempCategoryTitle.style.backgroundColor = "#191f51"; // Marineblau
                            tempCategoryTitle.style.color = "white";
                            tempCategoryTitle.innerHTML = response[element][dim2][0].fragekategorie;
                            tempCategory.appendChild(tempCategoryTitle);
    
                            questionsContainer.appendChild(tempCategory);
    
                            let fillerDiv = document.createElement("div");
                            fillerDiv.style.height = "2px";
    
                            tempCategory.appendChild(fillerDiv);
                        }	
                    }
                }
            }
    
            // Bereich für Verbesserungsvorschlag -------------------------------------------------
            let tempImprovementId = "students_questionnaire_improvement_suggestions";
            let tempImprovement = document.createElement("div");
    
            tempImprovement.id = tempImprovementId;
    
            let title = document.createElement("div");
            title.style.padding = "1px";
            title.style.backgroundColor = "#191f51"; // Marineblau
            title.style.color = "white";
            title.innerHTML = "Verbesserungsvorschläge";
            tempImprovement.appendChild(title);
    
            questionsContainer.appendChild(tempImprovement);
    
            let fillerDiv = document.createElement("div");
            fillerDiv.style.height = "10px";
            tempImprovement.appendChild(fillerDiv);
    
            let suggestionInputContainer = document.createElement("div");
            tempImprovement.appendChild(suggestionInputContainer);
            let suggestionInput = document.createElement("textarea");
            suggestionInput.placeholder = "Bei Bedarf kannst du hier deine Verbesserungsvorschläge angeben.";
            suggestionInput.rows = "rows";
            suggestionInput.cols = "cols";
            suggestionInput.style.width = "99%";
            suggestionInput.style.height = "100px";
            suggestionInput.style.fontSize = "x-large";
            suggestionInput.style.fontFamily = "calibri";
            suggestionInput.style.padding = "5px";
            suggestionInput.style.resize = "none";
            suggestionInputContainer.appendChild(suggestionInput);
    
            let fillerDiv2 = document.createElement("div");
            fillerDiv2.style.height = "5px";
            tempImprovement.appendChild(fillerDiv2);
    
            // Bereich mit Button zum Absenden ------------------------------------------------
            let sendButtonId = "students_questionnaire_send_button";
            let sendButton = document.createElement("div");
            sendButton.style.textAlign = "center";
            sendButton.id = sendButtonId;
    
            let button = document.createElement("button");
            button.style.padding = "1px";
            button.style.height = "30px";
            button.style.width = "200px";
            button.style.fontFamily = "calibri";
            button.style.fontSize = "large";
            button.innerHTML = "Absenden";
            sendButton.appendChild(button);
            button.addEventListener("mousedown", ()=>{
                //array('rate' : array('frageid' : string(FrageID), 'bogenid' : string(FragebogenID), 'bewertung' : int(FrageBewertung),  (...)) string('codehash' : )
    
                let rate = "{";
                let counter = 0;
                // anzahl der Fragen ermitteln
                let answersLength = 0;
                for(let answer in this.answers)
                {
                    if (this.answers[answer]!= null)
                    {
                        answersLength++;
                    }
                }
                console.log("answersLength");
                console.log(answersLength);

                for(let answer in this.answers)
                {
                    if (this.answers[answer]!= null)
                    {
                        let tempQuestionAnswer = {};
                        tempQuestionAnswer["bogenid"] = this.questionnaireId;
                        tempQuestionAnswer["frageid"] = answer;
                        tempQuestionAnswer["bewertung"] = this.answers[answer];
        
                        rate += JSON.stringify(tempQuestionAnswer);
    
                        console.log(counter);
                        console.log(counter < answersLength -1)
    
                        if (counter < answersLength -1 )
                        {
                            rate += ",";
                            counter++;
                        } 
                    }  
                }
                rate += "}";
                
                console.log("requestArray_rate:");

                console.log("stringified:");
                rate = JSON.stringify(rate);
                console.log(rate);

                //rate = JSON.parse(rate);
                console.log("parsed:");
                console.log(rate);

                // Request an insertRate
                let xhttp = new XMLHttpRequest()
                let response = undefined;
                let formData = new FormData();
                formData.append("codehash", this.codehash);
                formData.append("rate", rate);

                let path = "./php/main.php?mode=insertRate";

                xhttp.open("POST", path, true);

                xhttp.onreadystatechange = ()=>{
					if ( xhttp.readyState == 4 && xhttp.status == 200 )
					{
						response = xhttp.responseText;
                        console.log("response_insertRate");
                        console.log(response);
						try
						{

                        }
                        catch(error)
                        {

                        }
                    }
                }
                xhttp.send(formData);

            });
    
            questionsContainer.appendChild(sendButton);
    
            let fillerDiv3 = document.createElement("div");
            fillerDiv3.style.height = "5px";
            sendButton.appendChild(fillerDiv3);
    
            //--------------------------------------------------------------------------------
    
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
    
             // Bereich für Verbesserungsvorschläge
    
    
    
    
             console.log("The Answers");
             console.log(this.answers);
    
            // studentsQuestionnaireContainer einblenden
            this.fadeElementIn(studentsQuestionnaireContainer);

        

    }

    fadeElementIn(element)
    {
        // Element einblenden
        var timestamp = Math.floor(Date.now());
        let interval = setInterval(()=>{
        let tempTimestamp = Math.floor(Date.now());			
        element.style.opacity = ((tempTimestamp - timestamp) / 1000).toString();
        element.style.visibility = "visible";
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
        //formTableColumQuestion.style.backgroundColor = "#ededed";

        // Spalte für Antwortauswahl
        let formTableColumnAnswerSelection = document.createElement("td");
        formTableRow.appendChild(formTableColumnAnswerSelection);
        formTableColumnAnswerSelection.style.width = "30%";

    // -------------------------------------------------------------------------

        // Tabelle für Antwortmöglichkeiten
        let tableAnswerSelection = document.createElement("table");
        tableAnswerSelection.style.width = "100%";
        tableAnswerSelection.style.maxHeight = "40px";
        //tableAnswerSelection.style.borderCollapse = "collapse";
        tableAnswerSelection.style.borderStyle = "none";
        tableAnswerSelection.style.borderWidth = "1px";

        let rowAnswerSelection = document.createElement("tr");

        let AnswerValues = [];
        AnswerValues[0] = [];
        AnswerValues[0][0] = "+ +";
        AnswerValues[0][1] = "2";
        AnswerValues[0][2] = "#84d4b7"; //Slightly desaturated cyan - lime green

        AnswerValues[1] = [];
        AnswerValues[1][0] = "+";
        AnswerValues[1][1] = "1";
        AnswerValues[1][2] = "#c5e384"; //yellow-green

        AnswerValues[2] = [];
        AnswerValues[2][0] = "o";
        AnswerValues[2][1] = "0";
        AnswerValues[2][2] =  "#d3d3d3"; //light gray
        AnswerValues[3] = [];
        AnswerValues[3][0] = "-";
        AnswerValues[3][1] = "-1";
        AnswerValues[3][2] = "#f8b878"; //mellow-apricot

        AnswerValues[4] = [];
        AnswerValues[4][0] = "- -";
        AnswerValues[4][1] = "-2";
        AnswerValues[4][2] = "#e47069"; // soft red

        let switchesTempColumns = [];
        let tempColumns = [];

        for(let i = 0; i < AnswerValues.length; i++)
        {
            tempColumns[i] = document.createElement("td");
            tempColumns[i].style.width = "1%";
            if (i != 2) tempColumns[i].style.fontSize = "x-large";
            else tempColumns[i].style.fontSize = "large";
            tempColumns[i].style.textAlign = "center";
            tempColumns[i].style.fontWeight = "medium";
            tempColumns[i].style.borderStyle = "none";
            tempColumns[i].style.borderWidth = "1px";
            tempColumns[i].style.cursor = "pointer";
            tempColumns[i].style.color = "#191f51"; // Marineblau
            tempColumns[i].style.backgroundColor = "#ededed";//"#9eb3c7";
            tempColumns[i].style.userSelect = "none";
            tempColumns[i].id = questionId + "_" + AnswerValues[i][1];
            tempColumns[i].innerHTML = AnswerValues[i][0];

            switchesTempColumns[i] = false;
            //let value = questionId.split("_")
            let index = questionId.toString();
            this.answers[index] = AnswerValues[2][1];

            tempColumns[i].addEventListener("mouseenter", (event)=>{
                event.target.style.backgroundColor = AnswerValues[i][2];
            });
            tempColumns[i].addEventListener("mouseleave", (event)=>{
                if (!switchesTempColumns[i]) event.target.style.backgroundColor = "#ededed";
            });
            tempColumns[i].addEventListener("mousedown", (event)=>{
                if (!switchesTempColumns[i])
                {
                    switchesTempColumns[i] = true;
                    for(let j = 0; j < switchesTempColumns.length; j++)
                    {
                        if(i != j)
                        {
                            switchesTempColumns[j] = false;
                            tempColumns[j].style.backgroundColor = "#ededed";                         
                        }
                    }

                    // Setzen des Wertes für die Frage
                    let valueScore = event.target.id.split("_");
                    let index = valueScore[0];
                    let score = valueScore[1];
                    this.answers[index] = score;
                    console.log("answersOnMousedown:");
                    console.log(this.answers[index]);
                }
            });

            rowAnswerSelection.appendChild(tempColumns[i]);
        }
        tableAnswerSelection.appendChild(rowAnswerSelection);

        // Initalwerte für Switch "o" setzen
        switchesTempColumns[2] = true;
        tempColumns[2].style.backgroundColor = "#d3d3d3";

        // Tabelle zu Spalte für Antwortauswahl in der Muttertabelle hinzufügen
        formTableColumnAnswerSelection.appendChild(tableAnswerSelection);
    }
}