// Klasse Questionnaire

export default class Questionnaire
{
	constructor(questionnaire, questionnaireList)
	{
		 console.log("Aufruf von Klasse Questionnaire:");
		 console.log(questionnaire);

		this.functionManager = undefined;
		this.menuBarColor;
		this.unhighlightedColor = "#9eb3c7";
		this.id;
		this.amountStudents;
		this.questions;
		this.currentStatus;
		this.date;
		this.state = false;
		this.codes = [];
		this.qSubject = "";
		this.className = "";
		this.subject = "";


		let div = document.getElementById(questionnaire.id);

		if (div !== null) div.remove();
		else
		{
			div = document.createElement("div");
			div.className = "teacher_questionnaire";
			div.style.borderStyle = "solid";
			div.style.borderColor = this.unhighlightedColor;
			div.style.borderWidth = "1px";
			div.style.width = "99%";
			div.id = questionnaire.id;
			this.id = questionnaire.id;
	
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
				if (!this.state)
				{
					for(let td in tds)
					{
						if (tds[td].style != undefined)
						{
							tds[td].style.color = this.menuBarColor;
							tds[td].style.backgroundColor = this.unhighlightedColor;
						}
					}
					div.style.borderColor = this.unhighlightedColor;
				}
			});
			div.addEventListener("click", (event)=>{

				// Fallse der Bogen gelöscht oder vorzeitig abgeschlossen wird, wird das gewöhnliche Schließen oder öffen des Bogens nicht ausgeführt.
				if (event.target.className != "deleteButton" && event.target.className != "closeButton")
				{
					if (!this.state) this.state = true;
					else this.state = false;
	
					if (this.state)
					{
						this.ShowQuestions(div.id);
						for(let td in tds)
						{
							if (tds[td].style != undefined)
							{
								tds[td].style.color = "#ffffff";
								tds[td].style.backgroundColor = this.menuBarColor;
								
							}
						}
					}
					else
					{
						this.HideQuestions(div.id);
						for(let td in tds)
						{
							if (tds[td].style != undefined)
							{
								tds[td].style.color = this.menuBarColor;
								tds[td].style.backgroundColor = this.unhighlightedColor;
							}
						}
						div.style.borderColor = this.unhighlightedColor;
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
			columnSymbol.innerHTML = " &#128462;"; // 🗎-Zeichen
			columnSymbol.style.backgroundColor = this.unhighlightedColor;


			// TODO: Eventuell Button zum Anzeigen der Codes in Footer des Bogens verlegen
			let codesTag = document.createElement("div");
			codesTag.classList.add("show_codes_button");
			codesTag.classList.add("green");
			codesTag.innerHTML = "CODES";
			let tempCodesTagId = this.id + "_codesTag";
			codesTag.id = tempCodesTagId;
			codesTag.style.fontWeight = "bold";
			codesTag.addEventListener("click", (event)=>{

				event.stopPropagation();

        		// Asynchroner Request
				let xhttp = new XMLHttpRequest()
				let path = "./php/main.php?mode=getCodes";

				let formDataCodes = new FormData();
				formDataCodes.append("fbId", this.id);

				xhttp.onreadystatechange = ()=>{
					if ( xhttp.readyState == 4 && xhttp.status == 200 )
					{
						

						var responseQuestionnaireCodes = JSON.parse(xhttp.responseText);
						console.log("codes:");
                		console.log(responseQuestionnaireCodes);

                		// Abfrage ob noch Codes für den Bogen vorhanden sind
			   			if (responseQuestionnaireCodes.returncode != -1)
			   			{
							window.open("./html/codes.htm?fbId=" + this.id + "&qSubject=" + this.qSubject + "&subject=" + this.subject + "&className=" + this.className); 
							event.stopPropagation();
			   			}
						else
						{
							codesTag.classList.remove('green');
							codesTag.classList.add('red');
						}
            		}
        		}
        		xhttp.open("POST", path, true);
        		xhttp.send(formDataCodes);
			});
			

			columnSymbol.appendChild(codesTag);

			rowHeaders.append(columnSymbol);

			for (let index in questionnaire)
			{
				//console.log(response[questionnaire][index]);
				let columnHeaders = document.createElement("td");
				columnHeaders.className = "questionnaireHeader";

				let columnData = document.createElement("td");
	
				// Änderung der Header-Bezeichnungen
				if (index == "name") 
				{
					columnHeaders.innerHTML = "Thema";
					this.qSubject = questionnaire[index];

					// Breite der Spalten für Bogen-Thema

					// Header
					columnHeaders.style.width = "400px";
					columnHeaders.style.paddingLeft = "5px";

					// Daten
					columnData.style.width = "400px";
					columnData.style.paddingLeft = "5px";
				}
				else if (index == "zeitstempel") columnHeaders.innerHTML = "Datum";
				else if (index == "id") continue;
				else if (index == "anzfragen") continue;
				else if (index == "schueleranzahl")
				{
					columnHeaders.innerHTML = "Schüleranzahl";
					this.amountStudents = questionnaire[index];
				}
				else if (index == "klassenname")
				{
					columnHeaders.innerHTML = "Klasse";
					this.className = questionnaire[index];
				}
				else if (index == "fach")
				{
					this.subject = questionnaire[index];
					columnHeaders.innerHTML = "Fach";
				}
				else if (index == "bewertungsumme") 
				{
					columnHeaders.innerHTML = "Punkte";
				}
				else columnHeaders.innerHTML = index;
	
				columnHeaders.style.backgroundColor = this.unhighlightedColor;
				columnHeaders.style.fontWeight = "bold";
				columnHeaders.style.fontSize = "small";
				columnHeaders.style.color = this.menuBarColor;
				rowHeaders.appendChild(columnHeaders);
					
				//let columnData = document.createElement("td");
	
				// Zellen mit Daten hinzufügen
				if (index == "zeitstempel")
				{
					console.log("index:");
					console.log(index);
					let timestamp = questionnaire[index].split(" ");
					columnData.innerHTML = timestamp[0];
				}
				else if(index == "bewertungsumme")
				{
					let columnId = questionnaire.id + "_bewertungssumme";
					columnData.id = columnId;
					//getQuestionsAmount(questionnaireId, currentAmount, columnId)
					
					setTimeout(()=>{
						let interval = setInterval(()=>{
							this.computeAnswerValue( this.id, questionnaire[index], columnId);
							let dataContent = document.getElementById(columnId).innerHTML;
							console.log(dataContent.innerHTML);
							if (dataContent != undefined)
							{
								clearInterval(interval);
							}
						}, 100)
					}, 100)

				}
				else columnData.innerHTML = questionnaire[index];
	
				rowData.appendChild(columnData);			
			}
	
			// Bogenstatus Header hinzufügen
			let columnStatusHeader = document.createElement("td");
			columnStatusHeader.className = "questionnaireHeader";
			columnStatusHeader.style.color = this.menuBarColor;
			columnStatusHeader.style.fontWeight = "bold";
			columnStatusHeader.style.fontSize = "small";
			columnStatusHeader.innerHTML = "Status";
			columnStatusHeader.style.backgroundColor = "#9eb3c7";
			rowHeaders.appendChild(columnStatusHeader);
			// Bogenstatus hinzufügen
			let columnStatus = document.createElement("td");
			columnStatus.id = this.id + "_status";
			columnStatus.style.fontWeight = "bold";

			// Bogen-schließen Header hinzufügen
			let columnCloseHeader = document.createElement("td");
			columnCloseHeader.className = "questionnaireHeader";
			columnCloseHeader.style.color = this.menuBarColor;
			columnCloseHeader.style.fontWeight = "bold";
			columnCloseHeader.style.fontSize = "small";
			columnCloseHeader.style.textAlign = "center";
			columnCloseHeader.innerHTML = "Schließen";
			columnCloseHeader.style.backgroundColor = "#9eb3c7";
			rowHeaders.appendChild(columnCloseHeader);			
			// Bogen-löschen Header hinzufügen (leeres Datenfeld)
			let columnClose = document.createElement("td");
			columnClose.className = "closeButton";
			columnClose.style.fontSize = "20px";
			columnClose.style.textAlign = "center";
			columnClose.style.fontWeight = "bold";
			columnClose.innerHTML = "🔒";
			columnClose.addEventListener("click", (event)=>{

				let callback = (response)=>{
					let targetElement = document.getElementById("subMaskNotification_layer");
					targetElement.style.width = "100%";
					targetElement.style.height = "100%";
					targetElement.innerHTML = response;

					//event.stopPropagation();

					// Info zu Infofeld hinzufügen
					let messageContainer = document.getElementById("subMaskNotification_message");
					messageContainer.innerHTML = "Alle verbliebenen Codes des Bogens werden aus der Datenbank gelöscht. </br> Wollen Sie den Bogen abschließen"
	
					// Abbrechen Button
					let cancelButton = document.getElementById("subMaskNotification_cancel_button");
					cancelButton.addEventListener("click", ()=>{

						// Sub-Maske schließen
						targetElement.style.removeProperty("width");
						targetElement.style.removeProperty("height");
						document.getElementById("subMaskNotification_container").remove();
					});
	
					// Bestätigen Button
					let submitButton = document.getElementById("subMaskNotification_submit_button");
					submitButton.innerHTML = "Bogen abschließen";
					submitButton.addEventListener("click", ()=>{

						//event.preventDefault();
						let formdata = new FormData();
						formdata.append("fbId", this.id);
						let response = this.Request("./php/main.php?mode=deleteAllCodes", formdata, null);

						if (response == "true"){
							columnStatus.innerHTML = "abgeschlossen";
							columnStatus.style.color = "green";

							// Sub-Maske schließen
							targetElement.style.removeProperty("width");
							targetElement.style.removeProperty("height");
							document.getElementById("subMaskNotification_container").remove();
						}
						else
						{
							// Meldung bei einem Fehler ausgeben!
						}
						event.stopPropagation();
					});
				}

				let formData = new FormData();
				formData.append("fbId", this.id);
				let response = this.Request( "./php/main.php?mode=getCodes", formData, null);
				console.log(response);
				let responseQuestionnaireCodes = JSON.parse(response);

					// Anzeige des Bogenstatus auf Page "Übersicht";
					if (responseQuestionnaireCodes.returncode == -1)
					{
						// Status abgeschlossen
						// TODO: Eventuell Nachricht, dass der Bogen bereits abgeschlossen ist.
						// Keine hohe Prio
					}
					else if (responseQuestionnaireCodes.returncode == 0)
					{
						// Status offen
						// Sub-Maske zum Bestätigen des Löschvorgangs anzeigen
						this.Request("./html/subMaskNotification.htm", null, callback);
					}


			});




			// Bogen-löschen Header hinzufügen
			let columnDeleteHeader = document.createElement("td");
			columnDeleteHeader.className = "questionnaireHeader";
			columnDeleteHeader.style.color = this.menuBarColor;
			columnDeleteHeader.style.fontWeight = "bold";
			columnDeleteHeader.style.fontSize = "small";
			columnDeleteHeader.style.textAlign = "center";
			columnDeleteHeader.innerHTML = "Löschen";
			columnDeleteHeader.style.backgroundColor = "#9eb3c7";
			rowHeaders.appendChild(columnDeleteHeader);
			// Bogen-löschen Header hinzufügen (leeres Datenfeld)
			let columnDelete = document.createElement("td");
			columnDelete.className = "deleteButton";
			columnDelete.style.fontSize = "30px";
			columnDelete.style.textAlign = "center";
			columnDelete.style.fontWeight = "bold";
			columnDelete.innerHTML = "🗑";
			columnDelete.addEventListener("click", (event)=>{

				let callback = (response)=>{
					let targetElement = document.getElementById("subMaskNotification_layer");
					targetElement.style.width = "100%";
					targetElement.style.height = "100%";
					targetElement.innerHTML = response;

					//event.stopPropagation();

					// Info zu Infofeld hinzufügen
					let messageContainer = document.getElementById("subMaskNotification_message");
					messageContainer.innerHTML = "Soll der Fragebogen mit all seinen Verknüpfungen entgültig gelöscht werden?";
	
					// Abbrechen Button
					let cancelButton = document.getElementById("subMaskNotification_cancel_button");
					cancelButton.addEventListener("click", ()=>{

						// Sub-Maske schließen
						targetElement.style.removeProperty("width");
						targetElement.style.removeProperty("height");
						document.getElementById("subMaskNotification_container").remove();
					});
	
					// Bestätigen Button
					let submitButton = document.getElementById("subMaskNotification_submit_button");
					submitButton.innerHTML = "Bogen löschen";
					submitButton.addEventListener("click", ()=>{

						let formdata = new FormData();
						formdata.append("fbId", this.id);
						console.log(JSON.parse(this.Request("./php/main.php?mode=delQuestionnaire", formdata, null)));
						event.stopPropagation();
						document.getElementById(questionnaire.id).remove();

						console.log("Questionnaire.functionManager:");
						console.log(this.functionManager);

						this.functionManager.SortQuestionnairesWithFilters();


						// Sub-Maske schließen
						targetElement.style.removeProperty("width");
						targetElement.style.removeProperty("height");
						document.getElementById("subMaskNotification_container").remove();
					});
				}
				// Sub-Maske zum Bestätigen des Löschvorgangs anzeigen
				this.Request("./html/subMaskNotification.htm", null, callback);
			});
			

			// Asynchroner Request zum Nachladen des Bogenstatus
			let xhttp = new XMLHttpRequest()
			let path = "./php/main.php?mode=getCodes";

			let formDataCodes = new FormData();
			formDataCodes.append("fbId", questionnaire.id);

			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					//questionnaireList.appendChild(document.createElement("br"));


					var responseQuestionnaireCodes = JSON.parse(xhttp.responseText);

					//console.log("Bogenstatus:");
					//console.log(responseQuestionnaireCodes);

					// Anzeige des Bogenstatus auf Page "Übersicht";
					if (responseQuestionnaireCodes.returncode == -1)
					{
						columnStatus.innerHTML = "abgeschlossen";
						columnStatus.style.color = "green";	
					}
					else if (responseQuestionnaireCodes.returncode == 0)
					{
						columnStatus.innerHTML = "offen";
						columnStatus.style.color = "#feb460"; // orange
					}
					
					// Fragebogen Codes in this.codes speichern
					for(let i = 0; i < responseQuestionnaireCodes.returnvalue.length; i++)
					{
						this.codes.push(responseQuestionnaireCodes.returnvalue[i].codehash);
					}

					rowData.appendChild(columnStatus);

					// Zellen zum löschen und schließen hinzufügen
					rowData.appendChild(columnClose);
					rowData.appendChild(columnDelete);
			
					table.appendChild(rowHeaders);
					table.appendChild(rowData);
					div.appendChild(table);

					let questionContainer = document.createElement("div");
					questionContainer.id = div.id + "_question_container";
					questionContainer.style.width = "99%";
					questionContainer.style.margin = "auto";
					
					div.appendChild(questionContainer);
					
					questionnaireList.appendChild(div);
				}
			};
			xhttp.open("POST", path, true);
			xhttp.send(formDataCodes);
		}
	}


	HideQuestions(questionnaireId)
	{
		let tempQuestionnaire = document.getElementById(questionnaireId);
		tempQuestionnaire.style.borderColor = this.unhighlightedColor;
		document.getElementById(questionnaireId + "_question_container").innerHTML = "";
	}


	computeAnswerValue(questionnaireId, currentAmount, columnId)
	{
		console.log(questionnaireId + " / " + currentAmount + " / " + columnId);
		let xhttp = new XMLHttpRequest()
		let path = "./php/main.php?mode=getFbFragen";

		let formData = new FormData();
		formData.append("fbId", questionnaireId);

		xhttp.open("POST", path, true);
		xhttp.onreadystatechange = ()=>{
			if ( xhttp.readyState == 4 && xhttp.status == 200 )
			{
				let response = JSON.parse(xhttp.responseText);
				
				let questionsAmount = 0;
				for (let element in response.returnvalue)
				{
					for (let dim2 in response.returnvalue[element])
					{
						if (dim2.includes("frageid")) questionsAmount++;
					}
				}
				console.log("Anzahl Fragen:")
				console.log(questionsAmount);

				let tempColumn = document.getElementById(columnId);
				if (tempColumn != undefined) tempColumn.innerHTML = currentAmount + " / " + questionsAmount * this.amountStudents * 2;

			}
		}
		xhttp.send(formData);
	}

	ShowQuestions(questionnaireId)
	{
		let xhttp = new XMLHttpRequest()
		let path = "./php/main.php?mode=getFbFragen";

		let formData = new FormData();
		formData.append("fbId", questionnaireId);

		document.getElementById(questionnaireId).style.borderColor = this.menuBarColor;

		xhttp.onreadystatechange = ()=>{
			if ( xhttp.readyState == 4 && xhttp.status == 200 )
			{
				try
				{
					let response = JSON.parse(xhttp.responseText);
					console.log("showQuestions:");
					console.log(response);
	
					let tempCategoryBeforeSpacer = document.createElement("div");
					tempCategoryBeforeSpacer.style.height = "15px";
					tempCategoryBeforeSpacer.style.backgroundColor = "white";
					document.getElementById(questionnaireId + "_question_container").appendChild(tempCategoryBeforeSpacer);
					
					for (let element in response.returnvalue)
					{
						for (let dim2 in response.returnvalue[element])
						{
							if(response.returnvalue[element][dim2].fragestring != undefined && response.returnvalue[element][dim2].fragekategorie != undefined)
							{
								// Kategorie-Header hinzufügen, Zusammengesetzte Id aus Fragebogen-Id und Kategorie-Id
								let tempCategoryId = questionnaireId + "_expanded_questionnaire_category_" + response.returnvalue[element][dim2].fragekategorie;
								let tempCategory = document.getElementById(tempCategoryId);
	
								if (tempCategory == undefined) 
								{
									tempCategory = document.createElement("div");
									tempCategory.id = tempCategoryId;
									tempCategory.style.backgroundColor = "#191f51"; // Marineblau
									tempCategory.style.color = "white";
									tempCategory.style.fontSize = "16px";
									tempCategory.innerHTML = response.returnvalue[element][dim2].fragekategorie;
	
									let tempCategoryAfterSpacer = document.createElement("div");
									tempCategoryAfterSpacer.style.height = "5px";
									tempCategoryAfterSpacer.style.backgroundColor = "white";
									tempCategory.appendChild(tempCategoryAfterSpacer);
								}
	
								// Frage-Tabelle hinzufügen
								let tempQuestionContainer = document.createElement("div");
								//tempQuestionContainer.style.width = "99%";
								tempQuestionContainer.style.backgroundColor = "white";
								tempQuestionContainer.style.padding = "5px";
								tempQuestionContainer.id = questionnaireId + "_expanded_questionnaire_question_" + response.returnvalue[element].frageid;
								tempCategory.appendChild(tempQuestionContainer);
	
								let tempQuestionTable = document.createElement("table");
								tempQuestionTable.style.width = "100%";
								tempQuestionContainer.appendChild(tempQuestionTable);
	
								let tempQuestionTableRow = document.createElement("tr");
								tempQuestionTableRow.style.width = "99%";
								tempQuestionTable.appendChild(tempQuestionTableRow);
	
								// Frage
								let tempQuestionTableColumn1 = document.createElement("td");
								tempQuestionTableRow.appendChild(tempQuestionTableColumn1);
								tempQuestionTableColumn1.id = questionnaireId + "_expanded_questionnaire_question_" + response.returnvalue[element].frageid + "_text";
								tempQuestionTableColumn1.style.width = "55%";
								tempQuestionTableColumn1.style.backgroundColor = "white";
								tempQuestionTableColumn1.style.color = "black";
								tempQuestionTableColumn1.style.fontSize = "16px";
								tempQuestionTableColumn1.style.height = "22px";
								tempQuestionTableColumn1.innerHTML = response.returnvalue[element][dim2].fragestring;
	
								// Streuung
								let tempQuestionTableColumn2 = document.createElement("td");
								tempQuestionTableRow.appendChild(tempQuestionTableColumn2);
								tempQuestionTableColumn2.id = questionnaireId + "_expanded_questionnaire_scattering_" + response.returnvalue[element].frageid + "_sub_table_container";
								tempQuestionTableColumn2.style.width = "30%";
								tempQuestionTableColumn2.style.backgroundColor = "white";
								tempQuestionTableColumn2.style.color = "black";
								tempQuestionTableColumn2.style.fontSize = "16px";
								tempQuestionTableColumn2.style.height = "22px";

								// Sub-Tabelle für Streuungs-Daten
								let subTableContainerScattering = document.createElement("div");
								subTableContainerScattering.style.width = "99%";
								let subTableScattering = document.createElement("table");
								subTableScattering.style.width = "100%";
								subTableContainerScattering.appendChild(subTableScattering);
								let subTableScatteringRow = document.createElement("tr");
								subTableScattering.appendChild(subTableScatteringRow);


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

								// 100% aus höchstem Wert ermitteln
								let scatteringArray = [];
								for (let i = 0; i < 5; i++)
								{
									let currentStudentAmount = response.returnvalue[element][dim2][AnswerValues[i][1]];
									scatteringArray.push(parseInt(currentStudentAmount));
								}
								console.log("scattering:");
								console.log(scatteringArray);
								let max = Math.max(scatteringArray[0], scatteringArray[1],scatteringArray[2],scatteringArray[3],scatteringArray[4]);
								console.log("max:");
								console.log(max);

								for (let i = 0; i < 5; i++)
								{
									let currentStudentAmount = parseInt(response.returnvalue[element][dim2][AnswerValues[i][1]]);
									let opacity = (currentStudentAmount / max);//.toFixed(1);

									console.log("opacity:");
									console.log(opacity);

									let opacityMin = 0.0;
									if (opacity < opacityMin) opacity = opacityMin;
									console.log("a:");
									console.log(opacity);

									let tempSubTableScatteringColumn = document.createElement("td");
									tempSubTableScatteringColumn.style.width = "1%";

									console.log("rgba:");
									console.log(this.hexToRGBA(AnswerValues[i][2], opacity));

									// Anzeige der Streuung durch Änderung der Farbintensität
									tempSubTableScatteringColumn.style.backgroundColor = this.hexToRGBA(AnswerValues[i][2], opacity);

									tempSubTableScatteringColumn.style.textAlign = "center";
									tempSubTableScatteringColumn.innerHTML = "<b>" + AnswerValues[i][0] + "&#160;&#160; </b> " + currentStudentAmount + " x";
									subTableScatteringRow.appendChild(tempSubTableScatteringColumn);
								}
								tempQuestionTableColumn2.appendChild(subTableContainerScattering);
								
								//tempQuestionTableColumn2.innerHTML = response.returnvalue[element][dim2].fragestring;								

								// Erreichte Punkte
								let tempQuestionTableColumn3 = document.createElement("td");
								tempQuestionTableRow.appendChild(tempQuestionTableColumn3);
								tempQuestionTableColumn3.id = questionnaireId + "_expanded_questionnaire_question_" + response.returnvalue[element].frageid + "_Answer_value";
								tempQuestionTableColumn3.style.width = "15%";
								tempQuestionTableColumn3.style.backgroundColor = "white";
								tempQuestionTableColumn3.style.color = "black";
								tempQuestionTableColumn3.style.fontSize = "16px";
								tempQuestionTableColumn3.style.height = "22px";
								tempQuestionTableColumn3.style.textAlign = "right";
								tempQuestionTableColumn3.style.paddingRight = "50px";
								let tempValue = Number(response.returnvalue[element][dim2].fragebewertung);
								tempQuestionTableColumn3.innerHTML = tempValue.toFixed(2) + " Punkte von " + response.returnvalue[element][dim2].sumAnswers + " Schüler(n)";
								
	
								document.getElementById(questionnaireId + "_question_container").appendChild(tempCategory);
							}
						}
					}
	
					let tempContainer = document.getElementById(questionnaireId + "_question_container");//.appendChild(tempCategory);
					this.getKritik(this.id, tempContainer);
	
				}
				catch(error)
				{
					console.log("Fehler in Klasse Questionnaire.Questions():");
					console.log(error);
				}
			}
		};
		xhttp.open("POST", path, true);
		xhttp.send(formData);
	}

	addFooter()
	{
		let questionnaireFooter = document.createElement("div");
		document.getElementById(questionnaireId + "_question_container").appendChild(questionnaireFooter);
		questionnaireFooter.style.height = "30px";
		questionnaireFooter.style.width = "100%";

		let tempFooterTable = document.createElement("table");
		questionnaireFooter.appendChild(tempFooterTable);

		let tempFooterTableRow = document.createElement("tr");
		tempFooterTable.appendChild(tempFooterTableRow);

		let tempColumns = {};
		tempColumns.spacer = {"id":"spacer_" + this.id, "width":"70%", "title": ""};
		tempColumns.closeQuestionnaire = {"id":"closeQuestionnaire_" + this.id, "width":"70%", "title": "Bogen schließen"};
		tempColumns.deleteQuestionnaire = {"id":"deleteQuestionnaire_" + this.id, "width":"70%", "title": "Bogen löschen"};

		console.log("tempColumns");
		console.log(tempColumns);

		for (let column in tempColumns)
		{
			let tempColumn = document.createElement("td");
			tempFooterTableRow.appendChild(tempColumn)
			tempColumn.id = tempColumns[column].id;
			tempColumn.style.width = tempColumns[column].width;
			tempColumn.innerHTML = tempColumns[column].title;
		}
	}

	getKritik(questionnaireId, tempContainer)
	{
		let xhttp = new XMLHttpRequest()
		let path = "./php/main.php?mode=getkritik";
		let response = undefined;
		let formData = new FormData();
		formData.append("fbId", questionnaireId);

		xhttp.open("POST", path, true);
		xhttp.onreadystatechange = ()=>{
			if ( xhttp.readyState == 4 && xhttp.status == 200 )
			{
				console.log(xhttp.responseText);
				try
				{
					let response = JSON.parse(xhttp.responseText);
					console.log("kritik:");
					console.log(response);

					if (response.returncode != -1)
					{
						let tempSuggestionContainer = document.createElement("div");
						tempContainer.appendChild(tempSuggestionContainer);
	
						let tempSuggestionHeader = document.createElement("div");
						tempSuggestionHeader.innerHTML = "Verbesserungsvorschläge";
						//tempSuggestionHeader.style.paddingLeft = "10px";
						tempSuggestionHeader.style.backgroundColor = "#191f51"; // Marineblau
						tempSuggestionHeader.style.color = "white";
						tempSuggestionContainer.appendChild(tempSuggestionHeader);
	
						for (let suggestion in response.returnvalue)
						{
							// Wenn ein Verbesserungsvorschlag eingetragen wurde, wird dieser hinzugefügt.
							if (response.returnvalue[suggestion].length != 0)
							{
								let tempSuggestion = document.createElement("div");
								tempSuggestion.style.paddingTop = "10px";
								tempSuggestion.style.paddingBottom = "10px";
								tempSuggestion.style.paddingLeft = "10px";
		
								let span1 = document.createElement("span");
								span1.style.fontWeight = "bold";
								span1.innerHTML = "Anon: ";
								tempSuggestion.appendChild(span1);
		
								let span2 = document.createElement("span");
								span2.innerHTML = response.returnvalue[suggestion];
								tempSuggestion.appendChild(span2);
		
								tempSuggestionContainer.appendChild(tempSuggestion);
							}
						}
			
					}
					else
					{
						let tempSuggestionContainer = document.createElement("div");
						tempContainer.appendChild(tempSuggestionContainer);
	
						let tempSuggestionHeader = document.createElement("div");
						tempSuggestionHeader.innerHTML = "Verbesserungsvorschläge";
						//tempSuggestionHeader.style.paddingLeft = "10px";
						tempSuggestionHeader.style.backgroundColor = "#191f51"; // Marineblau
						tempSuggestionHeader.style.color = "white";
						tempSuggestionContainer.appendChild(tempSuggestionHeader);

						let tempSuggestion = document.createElement("div");
						tempSuggestion.style.paddingTop = "10px";
						tempSuggestion.style.paddingBottom = "10px";
						tempSuggestion.style.paddingLeft = "10px";

						let span1 = document.createElement("span");
						span1.style.fontWeight = "bold";
						span1.innerHTML = "keine";
						tempSuggestion.appendChild(span1);

						tempSuggestionContainer.appendChild(tempSuggestion);
					}

						// Footer mit Buttons zum Löschen des Bogens, sowie vorzeitigem abschließen hinzufügen
						//this.addFooter();
				}
				catch(error)
				{
					console.log(error);
				}

			}
		}
		xhttp.send(formData);
	}

	Request(path, formData, callback)
	{
		let response;
		let xhttp = new XMLHttpRequest();
		xhttp.open("POST", path, false);
		xhttp.send(formData);
		response = xhttp.responseText;

		if (callback != null) callback(response);

		//if (response.indexOf("{") != 0) return response;
		//if (response.length > 100 && response != null) return JSON.parse(response);
		return response;
	}



	hexToRGBA(h, a){
        let r = 0, g=0, b = 0;
        let r1 = this.decodeHex(h[1]) * 16;
        let r2 = this.decodeHex(h[2]) * 1;
        r = r1 + r2;
        let g1 = this.decodeHex(h[3]) * 16;
        let g2 = this.decodeHex(h[4]) * 1;
        g = g1 + g2;
        let b1 = this.decodeHex(h[5]) * 16;
        let b2 = this.decodeHex(h[6]) * 1;
        b = b1 + b2;
        return 'rgba('+r+','+g+','+b+','+a+')';
    }
    decodeHex(hex){
        if (hex == 'a'){return 10;}
        else if (hex == 'b') {return 11;}
        else if (hex == 'c') {return 12;}
        else if (hex == 'd') {return 13;}
        else if (hex == 'e') {return 14;}
        else if (hex == 'f') {return 15;}
        else {return parseInt(hex);}
    }


	convertToRGB(hex){
		if(hex.length != 6){
			throw "Only six-digit hex colors are allowed.";
		}
	
		var aRgbHex = hex.match(/.{1,2}/g);
		var aRgb = [
			parseInt(aRgbHex[0], 16),
			parseInt(aRgbHex[1], 16),
			parseInt(aRgbHex[2], 16)
		];
		return aRgb;
	}

}