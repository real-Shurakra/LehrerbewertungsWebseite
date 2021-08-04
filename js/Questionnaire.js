// Klasse Questionnaire

export default class Questionnaire
{
	constructor(questionnaire, questionnaireList)
	{
		// console.log("Aufruf von Klasse Questionnaire:");
		// console.log(questionnaire);

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
			div.addEventListener("click", ()=>{
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
			codesTag.innerHTML = "CODES";
			codesTag.style.fontSize = "10px";
			codesTag.style.fontWeight = "bold";
			codesTag.addEventListener("click", (event)=>{
				window.open("./html/codes.htm?fbId=" + this.id + "&qSubject=" + this.qSubject + "&subject=" + this.subject + "&className=" + this.className); 
				event.stopPropagation();
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
	
				if (index == "zeitstempel")
				{
					let timestamp = questionnaire[index].split(" ");
					columnData.innerHTML = timestamp[0];
				}
				else if(index == "bewertungsumme")
				{
					let columnId = questionnaire.id + "_bewertungsssumme";
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
			columnStatus.style.fontWeight = "bold";
			
			// Asynchroner Request
			let xhttp = new XMLHttpRequest()
			let path = "./php/main.php?mode=getCodes";

			let formDataCodes = new FormData();
			formDataCodes.append("fbId", questionnaire.id);

			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					questionnaireList.appendChild(document.createElement("br"));
					var responseQuestionnaireCodes = JSON.parse(xhttp.responseText);

					// Anzeige des Bogenstatus auf Page "Übersicht";
					if (responseQuestionnaireCodes.retruncode == -1)
					{
						columnStatus.innerHTML = "abgeschlossen";
						columnStatus.style.color = "green";	
					}
					else if (responseQuestionnaireCodes.retruncode == 0)
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
							tempQuestionContainer.style.backgroundColor = "white";
							tempQuestionContainer.style.padding = "5px";
							tempQuestionContainer.id = questionnaireId + "_expanded_questionnaire_question_" + response.returnvalue[element][dim2].frageid;
							tempCategory.appendChild(tempQuestionContainer);

							let tempQuestionTable = document.createElement("table");
							tempQuestionContainer.appendChild(tempQuestionTable);

							let tempQuestionTableRow = document.createElement("tr");
							tempQuestionTable.appendChild(tempQuestionTableRow);

							// Frage
							let tempQuestionTableColumn1 = document.createElement("td");
							tempQuestionTableRow.appendChild(tempQuestionTableColumn1);
							tempQuestionTableColumn1.id = questionnaireId + "_expanded_questionnaire_question_" + response.returnvalue[element][dim2].frageid + "_text";
							tempQuestionTableColumn1.style.width = "1%";
							tempQuestionTableColumn1.style.backgroundColor = "white";
							tempQuestionTableColumn1.style.color = "black";
							tempQuestionTableColumn1.style.fontSize = "16px";
							tempQuestionTableColumn1.style.height = "22px";
							// Zusammengesetzte Id aus Fragebogen-Id und Frage-Id
							tempQuestionTableColumn1.innerHTML = response.returnvalue[element][dim2].fragestring;

							// Erreichte Punkte
							let tempQuestionTableColumn2 = document.createElement("td");
							tempQuestionTableRow.appendChild(tempQuestionTableColumn2);
							tempQuestionTableColumn2.id = questionnaireId + "_expanded_questionnaire_question_" + response.returnvalue[element][dim2].frageid + "_Answer_value";
							tempQuestionTableColumn2.style.width = "1%";
							tempQuestionTableColumn2.style.backgroundColor = "white";
							tempQuestionTableColumn2.style.color = "black";
							tempQuestionTableColumn2.style.fontSize = "16px";
							tempQuestionTableColumn2.style.height = "22px";
							tempQuestionTableColumn2.style.textAlign = "right";
							tempQuestionTableColumn2.style.paddingRight = "50px";
							// Zusammengesetzte Id aus Fragebogen-Id und Frage-Id
							let tempValue = Number(response.returnvalue[element][dim2].fragebewertung);
							tempQuestionTableColumn2.innerHTML = tempValue.toFixed(2) + " / " + this.amountStudents * 2;
							

							document.getElementById(questionnaireId + "_question_container").appendChild(tempCategory);
						}
					}
				}

				let tempContainer = document.getElementById(questionnaireId + "_question_container");//.appendChild(tempCategory);
				this.getKritik(this.id, tempContainer);
			}
		};
		xhttp.open("POST", path, true);
		xhttp.send(formData);
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


				}
				catch(error)
				{
					console.log(error);
				}

			}
		}
		xhttp.send(formData);
	}

}