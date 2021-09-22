// Klasse FunctionMannager

import Questionnaire from "./Questionnaire.js";
import QuestionnaireStudents from "./QuestionnaireStudents.js";

export default class FunctionMannager
{
	constructor()
	{
		this.toolTipCreator1 = undefined;
		this.toolTipCreator2 = undefined;
		this.menuBarColor = undefined;
		this.menuOpacity = undefined;
		this.OverviewPageQuestionnaires = [];
		this.questionnaireCategoriesTableList = [];
		this.allAdded = false;
	}

	
	Uebersicht_page_0()
	{
		console.log(JSON.parse(this.Request("./php/main.php?mode=getAlleSchulklassen")));
		let responseClasses = JSON.parse(this.Request("./php/main.php?mode=getAlleSchulklassen"));
		
		// Dropdown für Klasse füllen
		let dropdownClasses = document.getElementById("questionnaire_filter_classes");
		dropdownClasses.innerHTML = "";
		let tempOption = document.createElement("option");
		tempOption.innerHTML = "keine";
		dropdownClasses.appendChild(tempOption);
		for (let i = 0; i < responseClasses.returnvalue.length; i++)
		{
			let tempOption = document.createElement("option");
			tempOption.innerHTML = responseClasses.returnvalue[i];
			tempOption.value = responseClasses.returnvalue[i];
			dropdownClasses.appendChild(tempOption);
		}
		
		
		let responseSubjects = JSON.parse(this.Request("./php/main.php?mode=getAllSubjects"));

		// Dropdown für Schulfach füllen
		let dropdownSubjects = document.getElementById("questionnaire_filter_subjects");
		dropdownSubjects.innerHTML = "";
		tempOption = document.createElement("option");
		tempOption.innerHTML = "keins"
		dropdownSubjects.appendChild(tempOption);
		for (let i = 0; i < responseSubjects.returnvalue.length; i++)
		{
			let tempOption = document.createElement("option");
			tempOption.innerHTML = responseSubjects.returnvalue[i];
			tempOption.value = responseSubjects.returnvalue[i];
			dropdownSubjects.appendChild(tempOption);
		}




		// Resettet alle Suchfilter und zeigt ALLE Bögen bei Page-Aufruf an
		// this.SortQuestionnairesWithFilters();
	}

	Uebersicht_page_event_0()
	{
		// Dropdown für Klasse füllen
		let responseClasses = JSON.parse(this.Request("./php/main.php?mode=getAlleSchulklassen"));

		let dropdownClasses = document.getElementById("questionnaire_filter_classes");
		dropdownClasses.innerHTML = "";
		dropdownClasses.addEventListener("input", ()=>{
			this.SortQuestionnairesWithFilters();
		});

		let tempOption = document.createElement("option");
		tempOption.innerHTML = "keine";
		dropdownClasses.appendChild(tempOption);
		for (let i = 0; i < responseClasses.returnvalue.length; i++)
		{
			let tempOption = document.createElement("option");
			tempOption.innerHTML = responseClasses.returnvalue[i];
			document.getElementById("questionnaire_filter_classes").appendChild(tempOption);
		}
		
		// Dropdown für Schulfach füllen
		let responseSubjects = JSON.parse(this.Request("./php/main.php?mode=getAllSubjects"));

		let dropdownSubjects = document.getElementById("questionnaire_filter_subjects");
		dropdownSubjects.innerHTML = "";
		dropdownSubjects.addEventListener("input", ()=>{
			this.SortQuestionnairesWithFilters();
		});

		tempOption = document.createElement("option");
		tempOption.innerHTML = "keins";
		dropdownSubjects.appendChild(tempOption);
		for (let i = 0; i < responseSubjects.returnvalue.length; i++)
		{
			let tempOption = document.createElement("option");
			tempOption.innerHTML = responseSubjects.returnvalue[i];
			document.getElementById("questionnaire_filter_subjects").appendChild(tempOption);
		}

		// Input-Feld für Themensuche
		let searchInputQSubjects = document.getElementById("questionnaire_filter_qSubject");
		searchInputQSubjects.addEventListener("input", ()=>{
			// TODO: Eventuell Methodenaufrufe durch "input"-Event in Queue speichern und nur letzes Element der Queue ausführen
			// Das gewünschte Ergebnis ist, dass nicht alle Aufrufe ausgeführt werden.
			setTimeout(()=>{
				this.SortQuestionnairesWithFilters();
			},500)
		});

		// Input-Feld für Datum "von"
		let inputFrom = document.getElementById("questionnaire_filter_from");
		inputFrom.addEventListener("input", ()=>{
			this.SortQuestionnairesWithFilters();
		});

		// Input-Feld für Datum "bis"
		let inputTo = document.getElementById("questionnaire_filter_to");
		inputTo.addEventListener("input", ()=>{
			this.SortQuestionnairesWithFilters();
		});

		// Input-Feld für Select "Status"
		let selectStatus = document.getElementById("questionnaire_filter_status");
		selectStatus.addEventListener("input", ()=>{
			this.SortQuestionnairesWithFilters();
		});

		/*
		// Größe von questionnaire_selection_area anpassen
		let questionnaireSelectArea = document.getElementById("questionnaire_select_area");
		let containerPages = document.getElementById("container_pages");
		questionnaireSelectArea.style.height = containerPages.getBoundingClientRect().height - 160 + "px";
		questionnaireSelectArea.style.width = containerPages.getBoundingClientRect().width - 160 + "px";
		console.log("questionnaireSelectArea:");
		console.log(questionnaireSelectArea.style);
		*/

		this.resizeElement("questionnaire_select_area");

		this.SortQuestionnairesWithFilters();


	}

	Request(path, formData) // zurzeit nicht genutzt
	{
		let response;
		let xhttp = new XMLHttpRequest();
		xhttp.open("POST", path, false);
		xhttp.send(formData);
		response = xhttp.responseText;

		//if (response.indexOf("{") != 0) return response;
		//if (response.length > 100 && response != null) return JSON.parse(response);
		return response;
	}

	
	Fragen_verwalten_page_0()
	{
		let existingQuestionsTable = document.getElementById("existing_questions_table");
		existingQuestionsTable.innerHTML = "";
		if ( existingQuestionsTable != undefined )
		{
			//aecd587fdc09
			//let path = "./php/main.php?mode=askAlleFragen";
			
			let path = "./php/main.php?mode=askAlleFragen";
			let dummyResponse;
			let xhttp = new XMLHttpRequest();
		
			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					try
					{
						//console.log(xhttp.responseText);
						dummyResponse = JSON.parse(xhttp.responseText);
						

						for ( let i = 0; i < dummyResponse.returnvalue[0].length; i++ )
						{
							let tableRowElement = document.createElement( "tr" );
							tableRowElement.id = dummyResponse.returnvalue[0][i].kategorie;
							
							let tableRowTitle = document.createElement( "div" );
							tableRowTitle.className = "title";
							tableRowTitle.innerHTML = dummyResponse.returnvalue[0][i].kategorie;
							tableRowElement.appendChild(tableRowTitle);
							existingQuestionsTable.appendChild(tableRowElement);
						}
					
						for ( let i = 0; i < dummyResponse.returnvalue[1].length; i++ )
						{
							let tableRowElement = document.getElementById( dummyResponse.returnvalue[1][i].kategorie );
							//tableRowElement.style.width = "100%";
						
							let subTable = document.createElement( "table" );
							subTable.style.width = "100%";
						
							let subTableRow = document.createElement( "tr" );
							//subTableRow.style.width = "100%";
							//if ( i % 2 > 0 ) subTable.style.backgroundColor = "#D3D3D3";
						
							let subTableColumnTextContainer = document.createElement( "td" );
							subTableColumnTextContainer.style.width = "95%";
							let subTableColumnButtonContainer = document.createElement( "td" );
						
							let subTableColumnText = document.createElement( "input" );
							subTableColumnText.type = "text";
							subTableColumnText.style.width = "99%";
							subTableColumnText.value = this.replaceAllUmlauts(dummyResponse.returnvalue[1][i].frage, false);
	
							//if ( !dummyResponse.questions[i].inUse ) subTableColumnText.style.color = "green";
							subTableColumnTextContainer.appendChild(subTableColumnText);
						
							let subTableColumnButton = document.createElement( "button" );
							subTableColumnButton.addEventListener("click", ()=>{
								
								let xhttp = new XMLHttpRequest();
								let formData = new FormData();
								formData.append("frageId", dummyResponse.returnvalue[1][i].id);
								formData.append("neuFrage", subTableColumnText.value);

								console.log("frageId: " + dummyResponse.returnvalue[1][i].id);
								console.log("neuFrage: " + subTableColumnText.value);

								let path = "./php/main.php?mode=alterQuestion";

								xhttp.open("POST", path, true);
								xhttp.addEventListener("readystatechange", ()=>{
									if(xhttp.readyState == 4 && xhttp.status == 200)
									{
										try
										{
											console.log(xhttp.responseText);
										}
										catch(error)
										{
											console.log(error);
										}
									}
								});
								xhttp.send(formData);
							});

							subTableColumnButton.id = dummyResponse.returnvalue[1][i].frage;
							subTableColumnButton.innerHTML = "Ändern";
							subTableColumnButtonContainer.appendChild(subTableColumnButton);
						
							subTableRow.appendChild( subTableColumnTextContainer );
							subTableRow.appendChild( subTableColumnButtonContainer );
							subTable.appendChild( subTableRow);
							
							if ( tableRowElement.id == dummyResponse.returnvalue[1][i].kategorie )
							{
								tableRowElement.appendChild( subTable );
							}
						}
							
					}
					catch( error )
					{
						console.log( error );
						console.log( dummyResponse );
					}
				}
			};
			xhttp.open("POST", path, true);
			xhttp.send(null);		
		}
	}
	
	Fragen_verwalten_page_1()
	{
		let selectFieldQuestionCategory = document.getElementById("select_question_category");
		selectFieldQuestionCategory.innerHTML = "";
		if ( selectFieldQuestionCategory != undefined )
		{
			let path = "./json/dummy.json";
			let dummyCategoriesResponse;
			let xhttp = new XMLHttpRequest();
		
			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					dummyCategoriesResponse = JSON.parse(xhttp.responseText);
				
					for ( let i = 0; i < dummyCategoriesResponse.categories.length; i++ )
					{
						let selectElement = document.createElement( "option" );
						selectElement.value = dummyCategoriesResponse.categories[i];
						selectElement.innerHTML = dummyCategoriesResponse.categories[i];
						selectFieldQuestionCategory.appendChild( selectElement );
					}
				}
			};
			xhttp.open("POST", path, true);
			xhttp.send();		
		}
	}
	
	Fragen_verwalten_page_event_0() // Frage anlegen Button
	{
		let createQuestionButton = document.getElementById("create_question");

		createQuestionButton.addEventListener("click", ()=>{
			let path = "./php/main.php?mode=addFrage";
			
			let category = document.getElementById("select_question_category").value;
			
			let question = document.getElementById("input_question_text").value;
			if (question.length < 1) return 0; // TODO Eventuell Message über nicht eingetragenen Text anzeigen lassen
			
			var formData = new FormData();
			formData.append( 'kategorie', category );
			formData.append( 'frage', question );
			
			let xhttp = new XMLHttpRequest();
			
			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					let response = JSON.parse( xhttp.responseText );
					
					try
					{
						this.displayMessage( "frage_anlegen_message", response ); 	// Infomessage anzeigen
						this.Fragen_verwalten_page_0(); 							// Seite aktualisieren
					}
					catch( error )
					{
						console.log( error );
						console.log( response );
					}
				
				}					
			}
			xhttp.open( "POST", path, true );
			xhttp.send( formData );	
		})
	}
	


	login_area_teacher()
	{
		var inputFieldTeacherEmail = document.getElementById("input_teacher_email");
		var inputFieldTeacherPassword = document.getElementById("input_teacher_password");
		var buttonTeacherLogin = document.getElementById("login_teacher_area");
		var response;
		
		if ( inputFieldTeacherEmail != undefined && inputFieldTeacherPassword != undefined && buttonTeacherLogin != undefined )
		{
			buttonTeacherLogin.addEventListener("mousedown", ()=>{
				let formData = new FormData();
				formData.append( 'mail', inputFieldTeacherEmail.value );
				formData.append( 'passwort', inputFieldTeacherPassword.value );
				
				let path = "./php/main.php?mode=loginUser";
				let dummyCategoriesResponse;
				let xhttp = new XMLHttpRequest();
				
				xhttp.onreadystatechange = ()=>{
					if ( xhttp.readyState == 4 && xhttp.status == 200 )
					{
						var responseRow = xhttp.responseText;

						try
						{
							response = JSON.parse( responseRow );

							if( response['returncode'] == 0 && response['returnvalue'] )
							{
								window.open("./verwaltung.php", "_self");
							}
							
						}
						catch( error )
						{
							console.log( error );
							console.log( response );
						}
					}
				};
				xhttp.open("POST", path, true);
				xhttp.send( formData );	
			});
		}
	}

	
	login_area_student()
	{
		// Begrenzung der Codeeingabe des Schülerbereiches auf Zahlen und zwei Ziffern
    	if (document.getElementById("input_area_students") != undefined);
    	{
        	var elements = document.getElementsByClassName("input_student");
        	if (elements.length != 0)
        	{
            	for(let i = 0; i < elements.length; i++)
            	{
					// Event-Listener für normalen Input
                	elements[i].addEventListener("input", ()=>{

                        let inputField = document.getElementById(elements[i].id);

                        let inputVal = inputField.value
                        var patt = /^[0-9]+$/;
                        if(patt.test(inputVal))
                        {
                            document.getElementById(elements[i].id).value = inputVal;
                        }
                        else
                        {
                            var txt = inputVal.slice(0, -1);
                            document.getElementById(elements[i].id).value = txt;
                        }

                        // Automatisches Auswählen des nächsten Eingabefeldes, sobald das Aktuelle ausgefüllt ist
                        if(inputVal.length == 2)
                        {
                            let nextNumber = parseInt(inputField.id.substr(2, 1)) + 1;
                            let nextElement = document.getElementById("nr" + nextNumber);
                            if (nextElement != undefined)
                            {
                                nextElement.focus();
                                nextElement.value = "";
                            }
                        }
                	})

					// Event-Listener für Backspace und DEL-Taste
					elements[i].addEventListener("keydown", (event)=>{

						var key = event.keyCode || event.charCode;

						// Auf Backspace oder DEL-Taste prüfen
						if( key == 8 || key == 46 )
						{
							let inputField = document.getElementById(elements[i].id);

							let inputVal = inputField.value

							// Automatisches Auswählen des vorherigen Eingabefeldes, sobald das Aktuelle geleert ist
							let previousNumber = parseInt(inputField.id.substr(2, 1)) - 1;
							let previousElement = document.getElementById("nr" + previousNumber);
							//var previousElementValue = previousElement.Value;
							if (previousElement != undefined)
							{
								if(inputVal.length == 0)
								{
									inputField.value = "";
									previousElement.focus();
									event.preventDefault();
								}
							}
						}
                	})

            	}
       		}   
    	}

		let inputFieldsStudents = document.querySelectorAll(".input_student");
		
		let inputs = [];

		NodeList.prototype.forEach.call(inputFieldsStudents, function (el) {
			//console.log(el);
			el.addEventListener("input", (event)=>{
				inputs[event.target.id] = event.target.value;

				// Textfarbe von allen Code-Inputfeldern wieder auf Default-Wert zurücksetzen
				let inputFieldsStudents = document.querySelectorAll(".input_student");
				NodeList.prototype.forEach.call(inputFieldsStudents, function (el) {
					el.style.color = "";
				})
				
			});
		})

		var buttonStudentOpenQuestionnaire = document.getElementById("open_questionnaire");
		
		buttonStudentOpenQuestionnaire.addEventListener("click", (event)=>{

			// Seite daran hindern neu zu laden
			event.preventDefault();

			// Prüfen ob in allen Code-Eingabefelder definiert sind
			if ( inputs["nr0"] != undefined && inputs["nr1"] != undefined && inputs["nr2"] != undefined && inputs["nr3"] != undefined )
			{
				let path = "./php/main.php?mode=getFbFragenFromCode";
				let response;
				let xhttp = new XMLHttpRequest();
				let formData = new FormData();

				let fullCodeString = "";
				let counter = 0;
				for(let element in inputs)
				{
					if(inputs[element].length < 2)
					{
						event.stopPropagation();
						break;
					}
					else
					{
						if( counter > 0 ) fullCodeString += "-" + inputs[element];
						else
						{
							fullCodeString += inputs[element];
							counter++;
						}
					}
				}
				formData.append("codehash",fullCodeString);
	
				xhttp.onreadystatechange = ()=>{
					if ( xhttp.readyState == 4 && xhttp.status == 200 )
					{
						response = xhttp.responseText;
						try
						{
							response = JSON.parse( response );
							console.log(response);

							if( response['returncode'] == 0 && response['returnvalue'] )
							{
								console.log("Der Fragebogen wurde geladen. . .");

								let questionnaireStudents = new QuestionnaireStudents(response, fullCodeString);
							}
							else
							{
								console.log("Der Code wurde entweder falsch eingegeben, oder für diesen Fragebogen gibt es keine gültigen Codes mehr.");

								// Benachrichtigung über falsch eingegebenen Code vorbereiten
								let notificationId = "wrong_code_notification";
								let tooltipContainer = document.getElementById(notificationId);
								if (tooltipContainer != undefined) tooltipContainer.remove();
								tooltipContainer = document.createElement("div");
								this.createNotificationInvalidCode(tooltipContainer);

								// Benachrichtigung über falsch eingegebenen Code einblenden
								this.fadeElementIn(tooltipContainer, 0.97);
								// Nach 5 Sek. wieder ausblenden
								setTimeout(()=>{ this.fadeElementOut(tooltipContainer); }, 5000);

								// Falsch eingegebenen Code in allen Eingabefeldern rot einfärben
								NodeList.prototype.forEach.call(inputFieldsStudents, function (el) {
									el.style.color = "#e47069"; // soft red
								})

							}
						}
						catch( error )
						{
							console.log( error );
							console.log( response );
						}
					}
				};
				xhttp.open("POST", path, false);
				xhttp.send( formData );
				//event.stopPropagation();
			}	
		});

			
	}

	login_areas_check_for_input()
	{
		//document.ad
	}


	Fragebogen_erstellen_page_0() // Aufbau der Eingabefelder und Kategoriebereiche
	{		
		let path = "./php/main.php?mode=askAlleFragen";
		var response;
		let xhttp = new XMLHttpRequest();
		
		let questionnaireCategoriesTable = document.getElementById("questionnaire_categories_table");
		
		xhttp.onreadystatechange = ()=>{
			if ( xhttp.readyState == 4 && xhttp.status == 200 )
			{
				response = JSON.parse(xhttp.responseText);


				// Aufbau der Fragebogen Tabelle mit den Kategorien (Diesen können anschließend auf der Page durch den User Fragen hinzugefügt werden)
				for ( let i = 0; i < response.returnvalue[0].length; i++ )
				{
					let tempId = "create_questionnaire_" + response.returnvalue[0][i].kategorie;
					if ( document.getElementById( tempId ) != null ) continue;
					
					let tableRowElement = document.createElement( "tr" );
					tableRowElement.id = tempId;
					
					let tableRowTitle = document.createElement( "div" );
					tableRowTitle.className = "title";
					tableRowTitle.innerHTML = response.returnvalue[0][i].kategorie;
					tableRowElement.appendChild(tableRowTitle);
					questionnaireCategoriesTable.appendChild(tableRowElement);
				}
				
				
				// Aufbau des Intelligenten Auswahl-Menüs für die Fragen
				this.addQuestionsDropDown();
				
			}
		}
		xhttp.open("POST", path, true);
		xhttp.send();
	}
	
	// TODO PHP Funktion zum Erhalt aller Fächer implementieren und Request von Dummy auf PHP Funktion entsprechend ändern
	Fragebogen_erstellen_page_1() // Auswahl der Schulklasse Dropdown, Auswahl des Schulfachs Dropdown 
	{
		let selectFieldQuestionnaireClass = document.getElementById("questionnaire_class_dropdown");
		selectFieldQuestionnaireClass.innerHTML = "";
		if ( selectFieldQuestionnaireClass != undefined )
		{
			let path = "./json/dummy.json";
			let response;
			let xhttp = new XMLHttpRequest();
		
			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					response = JSON.parse(xhttp.responseText);
				
					for ( let i = 0; i < response.classes.length; i++ )
					{
						let selectElement = document.createElement( "option" );
						selectElement.value = response.classes[i];
						selectElement.innerHTML = response.classes[i];
						selectFieldQuestionnaireClass.appendChild( selectElement );
					}
				}
			};
			xhttp.open("POST", path, true);
			xhttp.send();		
		}
		
		let selectFieldQuestionnaireSubject = document.getElementById("questionnaire_subject");
		selectFieldQuestionnaireSubject.innerHTML = "";
		if ( selectFieldQuestionnaireSubject != undefined )
		{
			let path = "./json/dummy.json";
			let response;
			let xhttp = new XMLHttpRequest();
		
			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					response = JSON.parse(xhttp.responseText);
				
					for ( let i = 0; i < response.subjects.length; i++ )
					{
						let selectElement = document.createElement( "option" );
						selectElement.value = response.subjects[i];
						selectElement.innerHTML = response.subjects[i];
						selectFieldQuestionnaireSubject.appendChild( selectElement );
					}
				}
			};
			xhttp.open("POST", path, true);
			xhttp.send();		
		}

		// HIER!!!
		this.resizeElement("create_questionnaire_area");
	}
	
	Fragebogen_erstellen_page_event_0() // Event-Listener für den Button zum Veröffentlichen eines Fragebogens
	{
		let publishQuestionnaireButton = document.getElementById("publish_questionnaire");
		
		// Tooltips fürs Intelligente Fragen-Auswahl-Menü
		let toolTipAddQuestionDropdownLeftClick = this.toolTipCreator1.createToolTip("Tooltip_mouse_left_click", "mouse_left_click", "add_question_dropdown");
		let toolTipAddQuestionDropdownRightClick = this.toolTipCreator1.createToolTip("Tooltip_mouse_right_click", "mouse_right_click", "add_question_dropdown");

		if(publishQuestionnaireButton != null)
		{
			publishQuestionnaireButton.addEventListener("click", ()=>{
			
				let questionnaireClassDropdown = document.getElementById("questionnaire_class_dropdown").value;
				//questionnaireClassDropdown = this.replaceAllUmlauts(questionnaireClassDropdown, true);
				
				let questionnaireStudentsAmount = document.getElementById("questionnaire_students_amount").value;
				let questionnaireUniqueName = document.getElementById("questionnaire_unique_name").value;
				let questionnaireSubject = document.getElementById("questionnaire_subject").value;
				
				//console.log(questionnaireClassDropdown + " " + questionnaireStudentsAmount + " " + questionnaireUniqueName + " " + questionnaireSubject);
				
		
				let questionnaireCategoriesTableList = this.getAllAddedQuestions();
				console.log("addedQuestions");
				console.log(questionnaireCategoriesTableList);

				var questionnaireQuestions = [];
				questionnaireQuestions["fragen"] = [];
				
				
				for(let table in questionnaireCategoriesTableList)
				{
					let tempQuestionId;
					// if (questionnaireCategoriesTableList[table].children != undefined) tempQuestion = questionnaireCategoriesTableList[table].children[0].children[0].firstChild.textContent;
					if (questionnaireCategoriesTableList[table].children != undefined)
					{
						//console.log("tempQuestionId");
						//console.log(questionnaireCategoriesTableList[table].children[0].children[0].id);
						tempQuestionId = questionnaireCategoriesTableList[table].children[0].children[0].id;
					}

					if (tempQuestionId != undefined) questionnaireQuestions.push(tempQuestionId);
				}
				
				console.log("questionnaireQuestions:");
				console.log(questionnaireQuestions);
				
				//console.log(questionnaireQuestions);
				
				if ( questionnaireClassDropdown != undefined && questionnaireStudentsAmount != undefined && questionnaireUniqueName != undefined && questionnaireQuestions.length > 0)
				{
					// console.log(questionnaireClassDropdown + " " + questionnaireStudentsAmount + " " + questionnaireUniqueName + " " + questionnaireSubject);
					
					let formData = new FormData();
					formData.append( 'name', questionnaireUniqueName );
					formData.append( 'anzahl', questionnaireStudentsAmount );
					formData.append( 'klasse', questionnaireClassDropdown );
					formData.append( 'fach', questionnaireSubject );
					formData.append( 'fragen', questionnaireQuestions);
			
					// console.log(formData);
			
					let path = "./php/main.php?mode=makeFragebogen";
					let xhttp = new XMLHttpRequest();
			
					let response;
					xhttp.onreadystatechange = ()=>{
						if ( xhttp.readyState == 4 && xhttp.status == 200 )
						{
							var responseRow = xhttp.responseText;
							try
							{
								response = JSON.parse( responseRow );
								console.log("Fragebogen erfolgreich angelegt Response:");
								console.log(response);
	
								if( response['retruncode'] == 0 )
								{
									//document.getElementById("messageCreateQuestionnaire").innerHTML = response['returnvalue'];

									// TODO: Methode zum nachladen der Bögen auf die Übersicht Page hier aufrufen
									// REM: Funktioniert noch nicht wie gewünscht
									this.SortQuestionnairesWithFilters();

									console.log("Fragebogen erfolgreich angelegt Response:");
									console.log(response);

									console.log("Der Fragebogen wurde angelegt und ist nun in der Übersicht verfügbar!");

									// Benachrichtigung über erfolgreich angelegten Fragebogen
									let notificationId = "successfull_created_notification";
									let tooltipContainer = document.getElementById(notificationId);
									if (tooltipContainer != undefined) tooltipContainer.remove();
									tooltipContainer = document.createElement("div");
									let target = document.getElementById("publish_questionnaire");
									this.createNotificationCreationSuccessfull(tooltipContainer, target);
									
									// Benachrichtigung über erfolgreich angelegten Fragebogen einblenden
									this.fadeElementIn(tooltipContainer, 0.97);
									// Nach 5 Sek. wieder ausblenden
									setTimeout(()=>{ this.fadeElementOut(tooltipContainer); }, 5000);
								}
							}
							catch( error )
							{
								console.log( error );
								console.log( responseRow );
							}
						}
					};
					xhttp.open("POST", path, true);
					xhttp.send( formData );
					this.removeAllAddedQuestions();
				}
				
				// Prüfung ob mindestens eine Frage für den Fragebogen ausgewählt wurde
				// HIER 01_08_2021
				if(questionnaireQuestions.length < 1)
				{
					console.log("Für den Bogen wurden keine Fragen ausgewählt. Ein Fragebogen muss zur Veröffentlichung mindestens eine Frage enthalten");

					// Benachrichtigung über Mindestanzahl der zur Erstellung des Fragebogens benötigten Fragen
					let notificationId = "min_question_amount_notification";
					let tooltipContainer = document.getElementById(notificationId);
					if (tooltipContainer != undefined) tooltipContainer.remove();
					tooltipContainer = document.createElement("div");
					let target = document.getElementById("publish_questionnaire");
					this.createNotificationMinQuestionAmountForCreation(tooltipContainer, target);
					
					// Benachrichtigung über falsch eingegebenen Code einblenden
					this.fadeElementIn(tooltipContainer, 0.97);
					// Nach 5 Sek. wieder ausblenden
					setTimeout(()=>{ this.fadeElementOut(tooltipContainer); }, 5000);
				}

			});			
		}

	}


	//== Subroutinen ==========================================================================================================================

	displayMessage( messageAreaId, response )
	{
		let timestampStart = Math.floor(Date.now());
		let responseMessage = document.getElementById( messageAreaId );
		responseMessage.style.opacity = 1;
		responseMessage.innerHTML = response['returnvalue'];
						
		var interval = setInterval(()=>{
			let currentTimestamp = Math.floor(Date.now());
			responseMessage.style.opacity = ( ( (1 - ( (currentTimestamp - timestampStart) / 1000) / 4) ) );
			
			if (responseMessage.style.opacity < 0)
			{
				responseMessage.innerHTML = "";
				clearInterval(interval);
			}
		}, 100);					
	}

	changeSelectedOptionBackgroundColor(option)
	{
		// console.log("... wirde ausgeführt!");

		// let questionnaireCategoriesTableList = this.getAllAddedQuestions();
		
		if(document.getElementById(option.id + "_addedQuestion") != undefined) option.style.backgroundColor = "#3EB489";	
		else option.style.backgroundColor = "";
	}

	getAllAddedQuestions()
	{
		console.log("getAllAddedQuestions");
		console.log(this.questionnaireCategoriesTableList);
		//this.questionnaireCategoriesTableList = [];
		this.questionnaireCategoriesTableList = document.querySelectorAll(".addedQuestion");//document.getElementsByClassName("addedQuestion");
		return this.questionnaireCategoriesTableList;
	}

	removeAllAddedQuestions()
	{
		Array.prototype.forEach.call(this.questionnaireCategoriesTableList, function (el) {
			el.remove();
		})

		// Einfärben der bereits hinzugefügten Fragen im Dropdown
		let addQuestionDropdownList = document.getElementById("add_question_dropdown").childNodes;
		for (let i = 0; i < addQuestionDropdownList.length; i++)
		{
			this.changeSelectedOptionBackgroundColor(addQuestionDropdownList[i]);
		}
	}

	replaceAllUmlauts(string, reverse)
	{
		// reverse = true kehrt das ersetzen der Codes um (Der Umlaut wird durch den Code ersetzt)
		var umlauts = {"Ä":"&#196;", "ä":"&#228;", "Ö":"&#214;", "ö":"&#246;", "Ü":"&#220;", "ü":"&#252;", "ß":"&#223;", "-":"&#45;"};
					
		if (!reverse)
		{
			for (var umlaut in umlauts)
			{
				while(string.includes(umlauts[umlaut]))
				{
					string = string.replace(umlauts[umlaut], umlaut);
				}
			}
		}
		else
		{
			for (var umlaut in umlauts)
			{
				while(string.includes(umlaut))
				{
					string = string.replace( umlaut, umlauts[umlaut]);
				}
			}
		}
		
		console.log(string);
		return string
	}

	addQuestionsDropDown()
	{
		let path = "./php/main.php?mode=askAlleFragen";
		var response;
		let xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = ()=>{
			if ( xhttp.readyState == 4 && xhttp.status == 200 )
			{
				response = JSON.parse( xhttp.responseText );
				// console.log("response askAlleFragen:");
				// console.log(response);

				let addQuestionDropdown = document.getElementById("add_question_dropdown");
				
				
				//if (document.getElementById("Tooltip_mouse_left_click") == null)
				

				//toolTipAddQuestionDropdownLeftClick.style.left = 180 + "px";
				//toolTipAddQuestionDropdownLeftClick.style.top = 180 + "px";

				//if (document.getElementById("Tooltip_mouse_right_click") == null )

				//toolTipAddQuestionDropdownRightClick.style.left =  + "px";
				//toolTipAddQuestionDropdownRightClick.style.top = 100 + "px";

				addQuestionDropdown.innerHTML = "";
				
				for ( var i = 0; i < response.returnvalue[1].length; i++ )
				{
					let selectElement = document.createElement( "div" );
					selectElement.className = "questionSelectElement";
				
					// Event-Listener für selectElement
					selectElement.addEventListener("contextmenu", (event)=>{
						event.preventDefault();
					});
					
					selectElement.addEventListener("mouseenter", (event)=>{
						event.target.style.fontWeight = "900";
						event.target.style.cursor = "pointer";
						//event.target.focus();
						
						let question = document.getElementById(event.target.id + "_addedQuestion");
						if (question != null)
						{
							question.style.backgroundColor = "#ff9999";
							question.scrollIntoView(true);
						}
					})
					
					selectElement.addEventListener("mouseleave", (event)=>{
						selectElement.style.fontWeight = "normal";
					
						let question = document.getElementById(event.target.id + "_addedQuestion");
						if (question != null) question.style.backgroundColor = "";

					})
					
					selectElement.addEventListener("mousedown", (event)=>{
						
					let triggers = [];
					triggers[0] = ()=>
					{
						let thisQuestion = document.getElementById( event.target.id + "_addedQuestion" );
						
						if(thisQuestion == undefined)
						{
							this.addQuestion(event.target);
							event.target.style.backgroundColor = "#3EB489";
						}
						else 
						{
							thisQuestion.remove();
							event.target.style.backgroundColor = "";
						}

					}
					triggers[2] = ()=>
					{
						this.addAllQuestions();

						let addQuestionDropdownList = document.getElementById("add_question_dropdown").getElementsByTagName("div");
						for (let i = 0; i < addQuestionDropdownList.length; i++)
						{
							addQuestionDropdownList[i].style.backgroundColor = "#3EB489";
						}
					}
					triggers[event.button]();
				
				})
			
				selectElement.addEventListener("mouseup", (event)=>{
				
					let question = document.getElementById(event.target.id + "_addedQuestion");
					if(question != null)
					{
						question.style.backgroundColor = "#ff9999";
						question.scrollIntoView(true);
					}
				})

					selectElement.value = response.returnvalue[1][i].frage;
					selectElement.id = response.returnvalue[1][i].frage;
					selectElement.innerHTML = response.returnvalue[1][i].kategorie + " &#8250; " + response.returnvalue[1][i].frage;
					selectElement.value = response.returnvalue[1][i].id;
					//console.log(selectElement.value);

					addQuestionDropdown.appendChild( selectElement );		
				}
				
				
				// Einfärben der bereits hinzugefügten Fragen im Dropdown
				let addQuestionDropdownList = document.getElementById("add_question_dropdown").childNodes;
				for (let i = 0; i < addQuestionDropdownList.length; i++)
				{
					this.changeSelectedOptionBackgroundColor(addQuestionDropdownList[i]);
				}
				
				
			}
		}
		xhttp.open("POST", path, true);
		xhttp.send();
	}
	
	addQuestion(question)
	{
			let path = "./php/main.php?mode=askAlleFragen";
			var response;
			let xhttp = new XMLHttpRequest();
			
			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					response = JSON.parse( xhttp.responseText );
					
					let tempValue = question.id;
					let tempId = question.value;
			
					let subTable = document.createElement( "table" );
					subTable.style.width = "100%";
					subTable.id = tempValue + "_addedQuestion";

					subTable.className = "addedQuestion";

					let subTableRow = document.createElement( "tr" );
					
					let subTableQuestion = document.createElement( "td" );
					subTableQuestion.id = tempId;
					//subTableQuestion.className ="addedQuestion";
					subTableQuestion.style.width = "95%";

					subTableQuestion.innerHTML = tempValue;
					subTableRow.appendChild( subTableQuestion );
	
					subTable.appendChild( subTableRow );
					
					for ( let i = 0; i < response.returnvalue[1].length; i++ )
					{	
						let category = "";
						if ( tempValue.includes( response.returnvalue[1][i].frage ) )
						{
							category = "create_questionnaire_" + response.returnvalue[1][i].kategorie;
							
							let categoryRow = document.getElementById( category );
							if ( document.getElementById( tempValue + "_addedQuestion" ) == null )
							{
								categoryRow.appendChild( subTable );
								
								// Automatisches Scrollen um hinzugefügte Frage ins Blickfeld zu bringen
								subTable.scrollIntoView(true);
								
								//subTable.style.backgroundColor = "red";
								
								// TODO Die ".scrollIntoView" Methode eventuell durch ".scrollTo" Methode austauschen mit genauen Angaben der Pos.
								// damit das Element sich vertikal mittig im Bildschirm befindet
								
								// Automatisches Zurückscrollen nach 0.75 Sekunden
								// setTimeout(()=>{ document.getElementById("create_questionnaire_area").scrollTo(0, 0) }, 750);
							}
							break;
						}
					}
				}
			}
			xhttp.open("POST", path, true);
			xhttp.send();
	}
	
	addAllQuestions()
	{
			let path = "./php/main.php?mode=askAlleFragen";
			var response;
			let xhttp = new XMLHttpRequest();
			
			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					response = JSON.parse( xhttp.responseText );
					
					let addQuestionDropdown = document.getElementById("add_question_dropdown").childNodes;
					
					var allQuestions = Array.from(addQuestionDropdown);
					
					for ( let i = 0; i < allQuestions.length; i++ )
					{
						let tempValue = allQuestions[i].id;
						let tempId = allQuestions[i].value;
			
						let subTable = document.createElement( "table" );
						subTable.style.width = "100%";
						subTable.id = tempValue + "_addedQuestion";

						subTable.className = "addedQuestion";

						let subTableRow = document.createElement( "tr" );
					
						let subTableQuestion = document.createElement( "td" );
						subTableQuestion.id = tempId;
						
						subTableQuestion.style.width = "95%";

						subTableQuestion.innerHTML = tempValue;
						subTableRow.appendChild( subTableQuestion );
	
						subTable.appendChild( subTableRow );
					
						for ( let j = 0; j < response.returnvalue[1].length; j++ )
						{	
							let category = "";
							if ( tempValue.includes( response.returnvalue[1][j].frage ) )
							{
								category = "create_questionnaire_" + response.returnvalue[1][j].kategorie;

								let categoryRow = document.getElementById( category );
								if ( document.getElementById( tempValue + "_addedQuestion" ) == null ) categoryRow.appendChild( subTable );
								break;
							}
						}
					}
					
					// Im Fragebogen automatisch nach ganz unten scrollen
					let addQuestionDropdownTemp = document.getElementById("add_question_dropdown");
					addQuestionDropdownTemp.scrollTo(0, addQuestionDropdownTemp.scrollHeight);
				}
			}
			xhttp.open("POST", path, true);
			xhttp.send();
	}


	SortQuestionnairesWithFilters()
	{
		let path = "./php/main.php?mode=getFragebogens";
		let response;
		let xhttp = new XMLHttpRequest();
		
		xhttp.onreadystatechange = ()=>{
			if ( xhttp.readyState == 4 && xhttp.status == 200 )
			{
				let questionnaireListContainer = document.getElementById("questionnaire_list_container");
				questionnaireListContainer.style.width = "99%";
				questionnaireListContainer.style.margin = "auto";
				
				// Leeren des Divs mit den Fragebögen
				var questionnaireList = document.getElementById("questionnaire_list");
				if (questionnaireList != undefined) questionnaireList.remove();
				questionnaireList = document.createElement("div");
				questionnaireList.id = "questionnaire_list";

				//questionnaireList.innerHTML = "";

				// Wird nach Filter-Feldern modifiziert
				response = JSON.parse(xhttp.responseText);
				console.log("SortQuestinnairesWithFilters");
				console.log(response);

				for (let questionnaire in response)
				{				
					// Filter KLasse gesetzt
					if(document.getElementById("questionnaire_filter_classes").value != "keine" && response[questionnaire] != undefined)
					{
						if (!response[questionnaire]["klassenname"].includes(document.getElementById("questionnaire_filter_classes").value))
						{
							response[questionnaire] = undefined;
						}
					}

					// Filter Fach gesetzt
					if (document.getElementById("questionnaire_filter_subjects").value != "keins" && response[questionnaire] != undefined)
					{
						if (!response[questionnaire]["fach"].includes(document.getElementById("questionnaire_filter_subjects").value))
						{
							response[questionnaire] = undefined;
						}
					}

					// Filter Thema-Suche gesetzt (gesuchtes Theme eingegeben)
					if (document.getElementById("questionnaire_filter_qSubject").value != "" && response[questionnaire] != undefined)
					{
						if (!response[questionnaire]["name"].includes(document.getElementById("questionnaire_filter_qSubject").value))
						{
							response[questionnaire] = undefined;
						}
					}

					// Nur Filter "von" gesetzt
					if (document.getElementById("questionnaire_filter_from").value != "" && response[questionnaire] != undefined)
					{
						let tempDate = document.getElementById("questionnaire_filter_from").value.split("-");

						tempDate = this.toTimestamp(tempDate[0], tempDate[1], tempDate[2]);

						if(document.getElementById("questionnaire_filter_to").value == "")
						{
							// Nur Datum des Fragebogens berücksichtigen
							let tempQuestionnaireTimestamp = response[questionnaire]["zeitstempel"].split(" ");
							tempQuestionnaireTimestamp = tempQuestionnaireTimestamp[0];
							tempQuestionnaireTimestamp = tempQuestionnaireTimestamp.split("-");
							tempQuestionnaireTimestamp = this.toTimestamp(tempQuestionnaireTimestamp[0], tempQuestionnaireTimestamp[1], tempQuestionnaireTimestamp[2]);

							// Wenn das Erstellungsdatum des Bogens kleiner ist als das eingestellte Datum wird der Bogen auf undefined gesetzt (aus Response-Array gelöscht)
							if (tempQuestionnaireTimestamp < tempDate) response[questionnaire] = undefined;
						}
					}

					// Nur Filter "bis" gesetzt
					if (document.getElementById("questionnaire_filter_to").value != "" && response[questionnaire] != undefined)
					{
						let tempDate = document.getElementById("questionnaire_filter_to").value.split("-");

						tempDate = this.toTimestamp(tempDate[0], tempDate[1], tempDate[2]);

						if(document.getElementById("questionnaire_filter_from").value == "")
						{
							// Nur Datum des Fragebogens berücksichtigen
							let tempQuestionnaireTimestamp = response[questionnaire]["zeitstempel"].split(" ");
							tempQuestionnaireTimestamp = tempQuestionnaireTimestamp[0];
							tempQuestionnaireTimestamp = tempQuestionnaireTimestamp.split("-");
							tempQuestionnaireTimestamp = this.toTimestamp(tempQuestionnaireTimestamp[0], tempQuestionnaireTimestamp[1], tempQuestionnaireTimestamp[2]);

							// Wenn das Erstellungsdatum des Bogens größer ist als das eingestellte Datum wird der Bogen auf undefined gesetzt (aus Response-Array gelöscht)
							if (tempQuestionnaireTimestamp > tempDate) response[questionnaire] = undefined;
						}
					}

					// Filter "von" und "bis" gesetzt
					if (document.getElementById("questionnaire_filter_from").value != "" && document.getElementById("questionnaire_filter_to").value != "" && response[questionnaire] != undefined)
					{
						let tempDateFrom = document.getElementById("questionnaire_filter_from").value.split("-");
						tempDateFrom = this.toTimestamp(tempDateFrom[0], tempDateFrom[1], tempDateFrom[2]);

						let tempDateTo = document.getElementById("questionnaire_filter_to").value.split("-");
						tempDateTo = this.toTimestamp(tempDateTo[0], tempDateTo[1], tempDateTo[2]);

						// Nur Datum des Fragebogens berücksichtigen
						let tempQuestionnaireTimestamp = response[questionnaire]["zeitstempel"].split(" ");
						tempQuestionnaireTimestamp = tempQuestionnaireTimestamp[0];
						tempQuestionnaireTimestamp = tempQuestionnaireTimestamp.split("-");
						tempQuestionnaireTimestamp = this.toTimestamp(tempQuestionnaireTimestamp[0], tempQuestionnaireTimestamp[1], tempQuestionnaireTimestamp[2]);

						// Wenn das Erstellungsdatum des Bogens kleiner ist als das eingestellte Datum wird der Bogen auf undefined gesetzt (aus Response-Array gelöscht)
						if (tempQuestionnaireTimestamp < tempDateFrom || tempQuestionnaireTimestamp > tempDateTo) response[questionnaire] = undefined;
					}

					// Filter "Status" gesetzt
					if(document.getElementById("questionnaire_filter_status").value != "keiner" && response[questionnaire] != undefined)
					{
						let tempId = response[questionnaire]["id"];
						console.log("tempId");
						console.log(tempId);

						let tempFilterValue = document.getElementById("questionnaire_filter_status").value
						console.log("tempFilterValue");
						console.log(tempFilterValue);

						this.filterQuestionnairesByStatus(tempId, tempFilterValue);
					}
				}

				// Gefilterte Bögen anzeigen
				for (let questionnaire in response)
				{
					if(response != undefined && response[questionnaire] != undefined)
					{
						let tempQuestionnaire = new Questionnaire(response[questionnaire], questionnaireList);
						tempQuestionnaire.menuBarColor = this.menuBarColor;
						this.OverviewPageQuestionnaires.push(tempQuestionnaire);
					}
				}
				console.log(this.OverviewPageQuestionnaires);
				
				questionnaireListContainer.appendChild(questionnaireList);
			}
		};
		xhttp.open("POST", path, true);
		xhttp.send();		
	}

	toTimestamp(year,month,day)
	{
		var datum = new Date(Date.UTC(year,month-1,day,0,0,0));
		return datum.getTime()/1000;
	}

	fadeElementIn(element, finalOpacity)
    {
        // Element einblenden
        var timestamp = Math.floor(Date.now());
        let interval = setInterval(()=>{
        let tempTimestamp = Math.floor(Date.now());			
        element.style.opacity = ((tempTimestamp - timestamp) / 1000).toString();
        element.style.visibility = "visible";
        if(((tempTimestamp - timestamp) / 1000) >= finalOpacity) clearInterval(interval);
        },25);
    }

	fadeElementOut(element)
    {
        // Element ausblenden und entfernen
		let opacity = element.style.opacity;
        var timestamp = Math.floor(Date.now());
        let interval = setInterval(()=>{
        let tempTimestamp = Math.floor(Date.now());			
        element.style.opacity = opacity - ((tempTimestamp - timestamp) / 1000).toString();
        if(element.style.opacity < 0)
		{
			element.remove();
			clearInterval(interval);
		}
        },25);
    }

	resizeElement(areaId)
	{
		// Größe von questionnaire_selection_area anpassen
		let containerPages = document.getElementById("container_pages");
		let area = document.getElementById(areaId);

		if (areaId == "questionnaire_select_area") area.style.height = containerPages.getBoundingClientRect().height - 160 + "px";
		if (areaId == "create_questionnaire_area") area.style.height = containerPages.getBoundingClientRect().height - 370 + "px";
		
		//area.style.width = containerPages.getBoundingClientRect().width - 155 + "px";

		console.log("area " + area.id + ":");
		console.log(area.style);
	}

	createNotificationInvalidCode(tooltipContainer)
	{
		tooltipContainer.id = "wrong_code_notification";
		tooltipContainer.style.visibility = "hidden";
		tooltipContainer.style.position = "absolute";
		tooltipContainer.style.left = "4%";
		tooltipContainer.style.zIndex = 10;
		let tooltipContainerWidth = 280;
		tooltipContainer.style.width = tooltipContainerWidth + "px";
		tooltipContainer.style.height = tooltipContainerWidth / 3 + "px";
		tooltipContainer.style.backgroundImage = "url(\"./html/tooltip_large.png\")";
		tooltipContainer.style.backgroundSize = "100% 100%";
		tooltipContainer.style.backgroundRepeat = "no-repeat";
		tooltipContainer.style.backgroundPosition = "top left";

		document.body.appendChild(tooltipContainer);
		let tooltipTable = document.createElement("table");
		tooltipTable.style.borderCollapse = "collapse";
		tooltipTable.style.width = "100%";
		tooltipTable.style.height = "100%";
		tooltipContainer.appendChild(tooltipTable);
		let tooltipRow = document.createElement("tr");
		tooltipTable.appendChild(tooltipRow);

		let toolTipElementIds = ["filler","notification_text"];
								
		for(let i = 0; i < toolTipElementIds.length; i++)
		{
			let tempColumn = document.createElement("td");

			tempColumn.id = toolTipElementIds[i];

			if(toolTipElementIds[i] != "filler")
			{
				tempColumn.style.textAlign = "left";
				tempColumn.style.fontFamily = "calibri";
				tempColumn.style.verticalAlign = "middle";
				tempColumn.style.fontWeight = "medium";
				//tempColumn.style.color = "red";
				tempColumn.style.padding = "auto";
				//tempColumn.innerText = "Der eingegebene Code ist ungültig!";
				tempColumn.style.width = "75%";

				let text1 = document.createElement("span");
				text1.style.fontFamily = "calibri";
				text1.innerText = "Der eingegebene Code ist ";
				tempColumn.appendChild(text1);

				let text2 = document.createElement("span");
				text2.style.fontFamily = "calibri";
				text2.innerText = "ungültig!";
				text2.style.color = "#e47069"; //soft red
				tempColumn.appendChild(text2);
			}
			else
			{
				tempColumn.style.width = "25%";
			}
			tempColumn.style.height = "100%";

			console.log(tempColumn);

			tooltipRow.appendChild(tempColumn);
		}
	}

	createNotificationMinQuestionAmountForCreation(tooltipContainer, target)
	{
		tooltipContainer.id = "min_question_amount_notification";
		tooltipContainer.style.visibility = "hidden";
		tooltipContainer.style.position = "absolute";
		let tooltipContainerWidth = 280;
		tooltipContainer.style.width = tooltipContainerWidth + "px";
		tooltipContainer.style.height = tooltipContainerWidth / 3 + "px";

		tooltipContainer.style.top = target.getBoundingClientRect().top + - parseInt(tooltipContainer.style.height) + 10 + "px";
		tooltipContainer.style.left = target.getBoundingClientRect().left + - parseInt(tooltipContainer.style.width) + "px";

		tooltipContainer.style.zIndex = 10;

		tooltipContainer.style.backgroundImage = "url(\"./html/Tooltip_arrow_pointing_right_bottom.png\")";
		//tooltipContainer.style.transform = "scaleY(-1)";
		tooltipContainer.style.backgroundSize = "100% 100%";
		tooltipContainer.style.backgroundRepeat = "no-repeat";
		tooltipContainer.style.backgroundPosition = "top left";

		document.body.appendChild(tooltipContainer);
		let tooltipTable = document.createElement("table");
		tooltipTable.style.borderCollapse = "collapse";
		tooltipTable.style.width = "100%";
		tooltipTable.style.height = "100%";
		tooltipContainer.appendChild(tooltipTable);
		let tooltipRow = document.createElement("tr");
		tooltipTable.appendChild(tooltipRow);

		let toolTipElementIds = ["notification_text","filler"];
								
		for(let i = 0; i < toolTipElementIds.length; i++)
		{
			let tempColumn = document.createElement("td");

			tempColumn.id = toolTipElementIds[i];

			if(toolTipElementIds[i] != "filler")
			{
				tempColumn.style.textAlign = "left";
				tempColumn.style.fontFamily = "calibri";
				tempColumn.style.fontSize = "large";
				tempColumn.style.verticalAlign = "middle";
				tempColumn.style.fontWeight = "medium";
				//tempColumn.style.color = "red";
				tempColumn.style.paddingBottom = "10px";
				tempColumn.style.paddingLeft = "30px";
				//tempColumn.innerText = "Der eingegebene Code ist ungültig!";
				tempColumn.style.width = "75%";

				let text1 = document.createElement("span");
				text1.style.fontFamily = "calibri";
				text1.innerText = "Der Fragebogen muss mindestens eine Frage enthalten!";
				tempColumn.appendChild(text1);

				/*
				let text2 = document.createElement("span");
				text2.style.fontFamily = "calibri";
				text2.innerText = "ungültig!";
				text2.style.color = "#e47069"; //soft red
				tempColumn.appendChild(text2);
				*/
			}
			else
			{
				tempColumn.style.width = "25%";
			}
			tempColumn.style.height = "100%";

			console.log(tempColumn);

			tooltipRow.appendChild(tempColumn);
		}
	}

	createNotificationCreationSuccessfull(tooltipContainer, target)
	{
		tooltipContainer.id = "successfull_created_notification";
		tooltipContainer.style.visibility = "hidden";
		tooltipContainer.style.position = "absolute";
		let tooltipContainerWidth = 280;
		tooltipContainer.style.width = tooltipContainerWidth + "px";
		tooltipContainer.style.height = tooltipContainerWidth / 3 + "px";

		tooltipContainer.style.top = target.getBoundingClientRect().top + - parseInt(tooltipContainer.style.height) + 10 + "px";
		tooltipContainer.style.left = target.getBoundingClientRect().left + - parseInt(tooltipContainer.style.width) + "px";

		tooltipContainer.style.zIndex = 10;

		tooltipContainer.style.backgroundImage = "url(\"./html/Tooltip_arrow_pointing_right_bottom.png\")";
		//tooltipContainer.style.transform = "scaleY(-1)";
		tooltipContainer.style.backgroundSize = "100% 100%";
		tooltipContainer.style.backgroundRepeat = "no-repeat";
		tooltipContainer.style.backgroundPosition = "top left";

		document.body.appendChild(tooltipContainer);
		let tooltipTable = document.createElement("table");
		tooltipTable.style.borderCollapse = "collapse";
		tooltipTable.style.width = "100%";
		tooltipTable.style.height = "100%";
		tooltipContainer.appendChild(tooltipTable);
		let tooltipRow = document.createElement("tr");
		tooltipTable.appendChild(tooltipRow);

		let toolTipElementIds = ["notification_text","filler"];
								
		for(let i = 0; i < toolTipElementIds.length; i++)
		{
			let tempColumn = document.createElement("td");

			tempColumn.id = toolTipElementIds[i];

			if(toolTipElementIds[i] != "filler")
			{
				tempColumn.style.textAlign = "left";
				tempColumn.style.fontFamily = "calibri";
				tempColumn.style.fontSize = "large";
				tempColumn.style.verticalAlign = "middle";
				tempColumn.style.fontWeight = "medium";
				//tempColumn.style.color = "red";
				tempColumn.style.paddingBottom = "10px";
				tempColumn.style.paddingLeft = "30px";
				//tempColumn.innerText = "Der eingegebene Code ist ungültig!";
				tempColumn.style.width = "75%";

				let text1 = document.createElement("span");
				text1.style.fontFamily = "calibri";
				text1.innerText = "Der Fragebogen ist nun in der ";
				tempColumn.appendChild(text1);
				
				let text2 = document.createElement("span");
				text2.style.fontFamily = "calibri";
				text2.innerText = "Übersicht ";
				text2.style.color = "green"; //TODO: Hex für Mint-Grün einfügen
				tempColumn.appendChild(text2);

				let text3 = document.createElement("span");
				text3.style.fontFamily = "calibri";
				text3.innerText = "verfügbar";
				tempColumn.appendChild(text3);
				
			}
			else
			{
				tempColumn.style.width = "25%";
			}
			tempColumn.style.height = "100%";

			console.log(tempColumn);

			tooltipRow.appendChild(tempColumn);
		}
	}

	filterQuestionnairesByStatus(questionnaireId, filterStatus)
	{	
		// Asynchroner Request
		let xhttp = new XMLHttpRequest()
		let path = "./php/main.php?mode=getCodes";
		
		let formDataCodes = new FormData();
		formDataCodes.append("fbId", questionnaireId);
		
		xhttp.onreadystatechange = ()=>{
			if ( xhttp.readyState == 4 && xhttp.status == 200 )
			{
				var responseQuestionnaireCodes = JSON.parse(xhttp.responseText);
		
				let responseStatus = undefined;

				// Ermitteln des Bogenstatus anhand der Anzahl der verbliebenen Codes
				if (responseQuestionnaireCodes.retruncode == -1)
				{
					responseStatus = "abgeschlossen";
				}
				else if (responseQuestionnaireCodes.retruncode == 0)
				{
					responseStatus = "offen";
				}

				setTimeout(()=>{
					let interval = setInterval(()=>{
						if (!responseStatus.includes(filterStatus))
						{
							let questionnaire = document.getElementById(questionnaireId);

							if (questionnaire != undefined) 
							{
								questionnaire.remove();
								clearInterval(interval);
							}
						}
					},100)
				},100)

			}
		};
		xhttp.open("POST", path, true);
		xhttp.send(formDataCodes);
	}

}