// pageCreateQuestions.js

let listener = setInterval( ()=>{
	let selectFieldQuestionCategory = document.getElementById("select_question_category");
	selectFieldQuestionCategory.innerHTML = "";
	if ( selectFieldQuestionCategory != undefined )
	{
		selectFieldQuestionCategory.addEventListener("mousedown", ()=>{

			let path = "./json/dummy.json";
			let dummyCategoriesResponse;
			let xhttp = new XMLHttpRequest();

				
			xhttp.onreadystatechange = ()=>{
				if ( xhttp.readyState == 4 && xhttp.status == 200 )
				{
					dummyCategoriesResponse = JSON.parse(xhttp.responseText);
				
					console.log(dummyCategoriesResponse);
				
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
		});
		clearInterval(listener);
	}
}, 500);






