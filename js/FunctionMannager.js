// Klasse FunctionMannager

export default class FunctionMannager
{
	constructor()
	{
		this.toolTipCreator1 = undefined;
		this.toolTipCreator2 = undefined;
		this.menuBarColor = undefined;
		this.menuOpacity = undefined;
	}
	
	Uebersicht_page_0()
	{
		let openQuestionnaires = document.getElementById("open_questionnaires");
		openQuestionnaires.innerHTML = "";
		if ( openQuestionnaires != undefined )
		{
			let path = "./php/main.php?mode=getFragebogens";
			let response;
			let xhttp = new XMLHttpRequest();
		
			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					response = JSON.parse(xhttp.responseText);
					
					console.log("getFragebogens");
					console.log(response);
					
					for (let questionnaire in response)
					{
						openQuestionnaires.appendChild(document.createElement("br"));
						
						let div = document.createElement("div");
						div.style.borderStyle = "solid";
						div.style.borderColor = "#9eb3c7";
						div.style.borderWidth = "1px";
						div.style.width = "99%";
						div.id = response[questionnaire].id;

						let tds = div.getElementsByClassName("questionnaireHeader");
						div.addEventListener("mouseenter", ()=>{
							div.style.cursor = "pointer";
							for(let td in tds)
							{
								if (tds[td].style != undefined)
								{
									tds[td].style.color = "#ffffff";
									tds[td].style.backgroundColor = this.menuBarColor;
									
								}
							}
						});
						div.addEventListener("mouseleave", ()=>{
							for(let td in tds)
							{
								if (tds[td].style != undefined)
								{
									tds[td].style.color = this.menuBarColor;
									tds[td].style.backgroundColor = "#9eb3c7";
								}
							}
						});
						
							let table = document.createElement("table");
							table.style.borderCollapse = "collapse";
							table.style.tableLayout = "fixed";
							table.style.width = "100%";
								let rowHeaders = document.createElement("tr");
								let rowData = document.createElement("tr");

								// Dokument-Symbol hinzufügen
								let columnSymbol = document.createElement("td");
								columnSymbol.className = "questionnaireHeader";
								columnSymbol.rowSpan = 2;
								columnSymbol.style.width = "50px";
								columnSymbol.style.fontSize = "40px";
								columnSymbol.style.textAlign = "center";
								columnSymbol.style.color = this.menuBarColor;
								columnSymbol.innerHTML = " &#128462;"; // 🗎
								columnSymbol.style.backgroundColor = "#9eb3c7";

								rowHeaders.append(columnSymbol);
									for (let index in response[questionnaire])
									{
										//console.log(response[questionnaire][index]);
										let columnHeaders = document.createElement("td");
										columnHeaders.className = "questionnaireHeader";

										// Änderung der Header-Bezeichnungen
										if (index == "name") columnHeaders.innerHTML = "Thema";
										else if (index == "zeitstempel") columnHeaders.innerHTML = "Datum";
										else if (index == "id") continue;
										else if (index == "anzfragen") continue;
										else if (index == "schueleranzahl") continue;
										else if (index == "klassenname") columnHeaders.innerHTML = "Klasse";
										else if (index == "fach") columnHeaders.innerHTML = "Fach";
										else if (index == "bewertungsumme") columnHeaders.innerHTML = "Punkte";
										else columnHeaders.innerHTML = index;

										columnHeaders.style.backgroundColor = "#9eb3c7";
										columnHeaders.style.fontWeight = "bold";
										columnHeaders.style.fontSize = "small";
										columnHeaders.style.color = this.menuBarColor;
										rowHeaders.appendChild(columnHeaders);
										
										let columnData = document.createElement("td");

										if (index == "zeitstempel")
										{
											let timestamp = response[questionnaire][index].split(" ");
											columnData.innerHTML = timestamp[0];
										}
										else columnData.innerHTML = response[questionnaire][index];
										
										rowData.appendChild(columnData);
									}
								table.appendChild(rowHeaders);
								table.appendChild(rowData);
							div.appendChild(table);
						openQuestionnaires.appendChild(div);
						
						// Event-Listener zum Hinzufügen der Fragen bei einem Klick auf den Bogen (Öffnen des Fragebogens)
						div.addEventListener("click", ()=>{
							let formData = new FormData();
							formData.append('fbId', div.id.toString());

							var response = this.Request("./php/main.php?mode=getFbFragen", formData);
							console.log(response);

							/*
							for ( let i = 0; i < response.returnvalue[0].length; i++ )
							{
								// TODO: Iteration durch die Fragen um diese dem Bogen hinzuzufügen
								// - Warten auf Anpassung der Backend-Methode "getFbFragen" (die Kategorien müssen noch hinzugefügt werden)	
							}
							*/
						});

					}
				}
			};
			xhttp.open("POST", path, true);
			xhttp.send();		
		}	
	}

	Request(path, formData)
	{
		let xhttp = new XMLHttpRequest();
		xhttp.open("POST", path, false);
		xhttp.send(formData);
		return JSON.parse(xhttp.responseText);
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
				var questionnaireQuestions = [];
				questionnaireQuestions["fragen"] = [];
				
				
				for(let table in questionnaireCategoriesTableList)
				{
					let tempQuestionId;
					// if (questionnaireCategoriesTableList[table].children != undefined) tempQuestion = questionnaireCategoriesTableList[table].children[0].children[0].firstChild.textContent;
					if (questionnaireCategoriesTableList[table].children != undefined)
					{
						tempQuestionId = questionnaireCategoriesTableList[table].children[0].children[0].id
					}

					if (tempQuestionId != undefined) questionnaireQuestions.push(tempQuestionId);
				}
				
				console.log(questionnaireQuestions);
				
				//console.log(questionnaireQuestions);
				
				if ( questionnaireClassDropdown != undefined && questionnaireStudentsAmount != undefined && questionnaireUniqueName != undefined )
				{
					console.log(questionnaireClassDropdown + " " + questionnaireStudentsAmount + " " + questionnaireUniqueName + " " + questionnaireSubject);
					
					let formData = new FormData();
					formData.append( 'name', questionnaireUniqueName );
					formData.append( 'anzahl', questionnaireStudentsAmount );
					formData.append( 'klasse', questionnaireClassDropdown );
					formData.append( 'fach', questionnaireSubject );
					formData.append( 'fragen', questionnaireQuestions);
			
					console.log(formData);
			
					let path = "./php/main.php?mode=makeFragebogen";
					let xhttp = new XMLHttpRequest();
			
					let response;
					xhttp.onreadystatechange = ()=>{
						if ( xhttp.readyState == 4 && xhttp.status == 200 )
						{
							var responseRow = xhttp.responseText;
							console.log(responseRow);
							try
							{
								response = JSON.parse( responseRow );
	
								if( response['returncode'] == 0 && response['returnvalue'] )
								{
									//window.open("./verwaltung.php", "_self");
									document.getElementById("messageCreateQuestionnaire").innerHTML = response['returnvalue'];
								}
								//document.getElementById("messageCreateQuestionnaire").innerHTML = response['returnvalue'];
						
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
		console.log("... wirde ausgeführt!");

		//let questionnaireCategoriesTableList = this.getAllAddedQuestions();
		
		if(document.getElementById(option.id + "_addedQuestion") != undefined) option.style.backgroundColor = "#3EB489";	
		else option.style.backgroundColor = "";
	}

	getAllAddedQuestions()
	{
		let questionnaireCategoriesTableList = [];
		questionnaireCategoriesTableList = document.getElementById("questionnaire_categories_table").getElementsByTagName("table");
		return questionnaireCategoriesTableList;
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
				console.log("response askAlleFragen:");
				console.log(response);

				let addQuestionDropdown = document.getElementById("add_question_dropdown");
				
				let toolTipAddQuestionDropdownLeftClick = this.toolTipCreator1.createToolTip("Tooltip_mouse_left_click", "mouse_left_click", "add_question_dropdown");

				//toolTipAddQuestionDropdownLeftClick.style.left = 180 + "px";
				//toolTipAddQuestionDropdownLeftClick.style.top = 180 + "px";

				let toolTipAddQuestionDropdownRightClick = this.toolTipCreator1.createToolTip("Tooltip_mouse_right_click", "mouse_right_click", "add_question_dropdown");
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
					let subTableRow = document.createElement( "tr" );
					
					let subTableQuestion = document.createElement( "td" );
					subTableQuestion.id = tempId;
					subTableQuestion.className ="addedQuestion";
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
	


}