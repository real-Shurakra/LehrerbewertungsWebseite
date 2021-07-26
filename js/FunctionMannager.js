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
						
							let subTableColumnText = document.createElement( "span" );
							subTableColumnText.innerHTML = dummyResponse.returnvalue[1][i].frage;
	
							//if ( !dummyResponse.questions[i].inUse ) subTableColumnText.style.color = "green";
							subTableColumnTextContainer.appendChild(subTableColumnText);
						
							let subTableColumnButton = document.createElement( "button" );
							subTableColumnButton.id = dummyResponse.returnvalue[1][i].frage;
							subTableColumnButton.innerHTML = "löschen";
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
		let inputFieldsStudents = document.querySelectorAll(".input_student");
		
		let inputs = [];

		NodeList.prototype.forEach.call(inputFieldsStudents, function (el) {
			//console.log(el);
			el.addEventListener("input", (event)=>{
				inputs[event.target.id] = event.target.value;
				//console.log(inputs[event.target.id]);
			});
		})

		var buttonStudentOpenQuestionnaire = document.getElementById("open_questionnaire");
		
		buttonStudentOpenQuestionnaire.addEventListener("click", (event)=>{

			// Seite daran hindern neu zu laden
			event.preventDefault();

			let questionnaireContainer = document.getElementById("students_questionnaire_container");
			questionnaireContainer.style.height = window.innerHeight - 125 + "px";
			questionnaireContainer.style.width = window.innerWidth - 500 + "px";
			questionnaireContainer.style.borderStyle = "solid";
			questionnaireContainer.style.borderColor = "#191f51"; // Marineblau
			questionnaireContainer.style.borderWidth = "1px";
			questionnaireContainer.style.top = "75px";
			questionnaireContainer.style.left = "275px";
			questionnaireContainer.style.padding = "10px";
			questionnaireContainer.style.opacity = "93%";

			if ( inputs["nr0"] != undefined && inputs["nr1"] != undefined && inputs["nr2"] != undefined && inputs["nr3"] )
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

								let questionnaireStudents = new QuestionnaireStudents(response);

								/*

								let loginAreaStudents = document.getElementById("login_area_student");
								loginAreaStudents.innerHTL = "";

								let horizontalMenuButtonStudents = document.getElementById("horizontal_menu_button_students");
								
								horizontalMenuButtonStudents.style.backgroundColor = "#191f51"; // Marineblau
								horizontalMenuButtonStudents.style.color = "white";
								horizontalMenuButtonStudents.style.height = "47px";
								horizontalMenuButtonStudents.style.borderStyle = "none";
								horizontalMenuButtonStudents.style.width = "500px";

								// TODO: In eigene Klasse auslagern
								//=======================================================================================
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
			studentsQuestionnaireContainer.appendChild(containerQuestionnaireTable);

			let rowHeaders = document.createElement("tr");
			//rowHeaders.style.borderLeft = "solid";
			//rowHeaders.style.borderBottom = "spolid";
			//rowHeaders.style.borderRight = "solid";

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
					//this.qSubject = response[index].thema;
				}
				else if (index == "zeitstempel") columnHeaders.innerHTML = "Datum-Erstellung";
				else if (index == "id") continue;
				else if (index == "anzfragen") continue;
				else if (index == "schueleranzahl")
				{
					columnHeaders.innerHTML = "Schüleranzahl";
					//this.className = questionnaire[index];
				}
				else if (index == "klassename")
				{
					columnHeaders.innerHTML = "Klassenname";
					//this.className = questionnaire[index];
				}
				else if (index == "fachname")
				{
					//this.subject = questionnaire[index];
					columnHeaders.innerHTML = "Fach";
				}
				else if (index == "bewertungsumme") columnHeaders.innerHTML = "Punkte";
				else columnHeaders.innerHTML = index;
	
				columnHeaders.style.backgroundColor = "#191f51"; // Marineblau
				columnHeaders.style.color = "white";
				columnHeaders.style.fontWeight = "bold";
				columnHeaders.style.fontSize = "small";
				columnHeaders.style.height = "25px";

				rowHeaders.appendChild(columnHeaders);
					
				let columnData = document.createElement("td");
				columnData.style.fontWeight = "bold";
				columnData.style.fontSize = "small";
				columnData.style.height = "25px";
	
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
								questionsContainer.style.overflowY = "scroll";
								questionsContainer.style.scrollbarWidth = "none";
								questionsContainer.style.height = studentsQuestionnaireContainer.getBoundingClientRect().height + "px";


								studentsQuestionnaireContainer.appendChild(questionsContainer);

								// Kategorien mit den Fragen hinzufügen
								for (let element in response)
								{
									for (let dim2 in response[element])
									{
										if(response[element][dim2][0].fragestring != undefined && response[element][dim2][0].fragekategorie != undefined)
										{
											// Kategorie-Header hinzufügen, Zusammengesetzte Id aus Fragebogen-Id und Kategorie-Id
											let tempCategoryId = "expanded_questionnaire_category_" + response[element][dim2][0].fragekategorie;
											let tempCategory = document.getElementById(tempCategoryId);

											if (tempCategory == undefined) 
											{
												tempCategory = document.createElement("div");
												tempCategory.id = tempCategoryId;
												tempCategory.style.backgroundColor = "#191f51"; // Marineblau
												console.log(this.menuBarColor);
												tempCategory.style.color = "white";
												tempCategory.style.fontSize = "16px";
												tempCategory.innerHTML = response[element][dim2][0].fragekategorie;

												let tempCategoryAfterSpacer = document.createElement("div");
												tempCategoryAfterSpacer.style.height = "5px";
												tempCategoryAfterSpacer.style.backgroundColor = "white";
												tempCategory.appendChild(tempCategoryAfterSpacer);
											}	
											// Frage hinzufügen
											let tempQuestion = document.createElement("div");
											tempQuestion.style.backgroundColor = "white";
											tempQuestion.style.color = "black";
											tempQuestion.style.fontSize = "16px";
											tempQuestion.style.height = "22px";
											// Zusammengesetzte Id aus Fragebogen-Id und Frage-Id
											tempQuestion.id = "expanded_questionnaire_question_" + response[element][dim2][0].frageid;
											tempQuestion.innerHTML = response[element][dim2][0].fragestring;
											tempCategory.appendChild(tempQuestion);

											questionsContainer.appendChild(tempCategory);
										}
									}
								}

								//studentsQuestionnaireContainer.appendChild(questionsContainer);

								// Fragebogen einblenden
								var timestamp = Math.floor(Date.now());
								let interval = setInterval(()=>{
									let tempTimestamp = Math.floor(Date.now());			
									studentsQuestionnaireContainer.style.opacity = ((tempTimestamp - timestamp) / 1000).toString();
									studentsQuestionnaireContainer.style.visibility = "visible";
									if(((tempTimestamp - timestamp) / 1000) >= 0.9) clearInterval(interval);
								},25);
								//=======================================================================================
								*/
							}
							else
							{
								console.log("Der Code wurde entweder falsch eingegeben, oder für diesen Fragebogen gibt es keine gültigen Codes mehr.");
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
				
				//console.log(questionnaireQuestions);
				
				//console.log(questionnaireQuestions);
				
				if ( questionnaireClassDropdown != undefined && questionnaireStudentsAmount != undefined && questionnaireUniqueName != undefined )
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
							// console.log(responseRow);
							try
							{
								response = JSON.parse( responseRow );
	
								if( response['returncode'] == 0 && response['returnvalue'] )
								{
									//window.open("./verwaltung.php", "_self");
									document.getElementById("messageCreateQuestionnaire").innerHTML = response['returnvalue'];
									
								}
								//document.getElementById("messageCreateQuestionnaire").innerHTML = response['returnvalue'];
						
								// TODO: Methode zum nachladen der Bögen auf die Übersicht Page hier aufrufen
								//this.SortQuestionnairesWithFilters();
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
					this.removeAllAddedQuestions();
					
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


}