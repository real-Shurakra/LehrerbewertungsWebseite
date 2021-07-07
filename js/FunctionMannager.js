// Klasse FunctionMannager

export default class FunctionMannager
{
	constructor()
	{
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
		document.addEventListener("mousedown", ()=>{
			if (document.getElementById("input_area_students") != undefined);
			{
				var elements = document.getElementsByClassName("input_student");
				console.log(elements);
				if (elements.length != 0)
				{
					for(let i = 0; i < elements.length; i++)
					{
						elements[i].addEventListener("input", ()=>{
		
								let inputVal = document.getElementById(elements[i].id).value
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
						})
					}
				}   
			}
		})		
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
				let addQuestionDropdown = document.getElementById("add_question_dropdown");
				addQuestionDropdown.innerHTML = "";
				
				response = JSON.parse(xhttp.responseText);
				
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
				
				for ( let i = 0; i < response.returnvalue[1].length; i++ )
				{
					let selectElement = document.createElement( "option" );
					selectElement.value = response.returnvalue[1][i].frage;
					selectElement.innerHTML = response.returnvalue[1][i].frage;
					addQuestionDropdown.appendChild( selectElement );
				}
				
			}
		}
		xhttp.open("POST", path, true);
		xhttp.send();
	}
	
	Fragebogen_erstellen_page_1() // Auswahl der Schulklasse Dropdown
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
	}
	
	Fragebogen_erstellen_page_event_0() // Frage hinzufügen Button
	{
		let addQuestionButton = document.getElementById( "addQuestion" );
		addQuestionButton.addEventListener("mousedown", ()=>{
			
			let path = "./php/main.php?mode=askAlleFragen";
			var response;
			let xhttp = new XMLHttpRequest();
			
			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					response = JSON.parse( xhttp.responseText );
					
					let addQuestionDropdown = document.getElementById("add_question_dropdown");
					
					let tempValue = addQuestionDropdown.value;
			
					let subTable = document.createElement( "table" );
					subTable.style.width = "100%";
					subTable.id = tempValue + "_addedQuestion";
					let subTableRow = document.createElement( "tr" );
					
					let subTableQuestion = document.createElement( "td" );
					subTableQuestion.style.width = "95%";

					subTableQuestion.innerHTML = tempValue;
					subTableRow.appendChild( subTableQuestion );
					
					let subTableRemoveQuestionButtonTd = document.createElement( "td" );
					
					let subTableRemoveQuestionButton = document.createElement( "button" );
					subTableRemoveQuestionButton.innerHTML = "entfernen"
					
					subTableRemoveQuestionButton.addEventListener("mousedown", ()=>{
						var thisQuestion = document.getElementById( tempValue + "_addedQuestion" );
						thisQuestion.remove();
					});

					subTableRemoveQuestionButtonTd.appendChild( subTableRemoveQuestionButton );

					subTableRow.appendChild( subTableRemoveQuestionButtonTd );
	
					subTable.appendChild( subTableRow );
					
					for ( let i = 0; i < response.returnvalue[1].length; i++ )
					{	
						let category = "";
						if ( tempValue.includes( response.returnvalue[1][i].frage ) )
						{
							category = "create_questionnaire_" + response.returnvalue[1][i].kategorie;
							
							let categoryRow = document.getElementById( category );
							if ( document.getElementById( tempValue + "_addedQuestion" ) == null ) categoryRow.appendChild( subTable );
							break;
						}
					}
				}
			}
			xhttp.open("POST", path, true);
			xhttp.send();
		});
	}
	
	Fragebogen_erstellen_page_event_1() // Alle Fragen hinzufügen Button
	{
		let addAllQuestionsButton = document.getElementById( "addAllQuestions" );
		addAllQuestionsButton.addEventListener("mousedown", ()=>{
			
			let path = "./php/main.php?mode=askAlleFragen";
			var response;
			let xhttp = new XMLHttpRequest();
			
			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					response = JSON.parse( xhttp.responseText );
					
					let addQuestionDropdown = document.getElementById("add_question_dropdown");
					
					var allQuestions = Array.from(addQuestionDropdown);
					
					for ( let i = 0; i < allQuestions.length; i++ )
					{
						let tempValue = allQuestions[i].value;
			
						let subTable = document.createElement( "table" );
						subTable.style.width = "100%";
						subTable.id = tempValue + "_addedQuestion";
						let subTableRow = document.createElement( "tr" );
					
						let subTableQuestion = document.createElement( "td" );
						subTableQuestion.style.width = "95%";

						subTableQuestion.innerHTML = tempValue;
						subTableRow.appendChild( subTableQuestion );
					
						let subTableRemoveQuestionButtonTd = document.createElement( "td" );
					
						let subTableRemoveQuestionButton = document.createElement( "button" );
						subTableRemoveQuestionButton.innerHTML = "entfernen"
					
						subTableRemoveQuestionButton.addEventListener("mousedown", ()=>{
							var thisQuestion = document.getElementById( tempValue + "_addedQuestion" );
							thisQuestion.remove();
						});

						subTableRemoveQuestionButtonTd.appendChild( subTableRemoveQuestionButton );

						subTableRow.appendChild( subTableRemoveQuestionButtonTd );
	
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
				}
			}
			xhttp.open("POST", path, true);
			xhttp.send();
		});
	}
}