// Klasse Gui


export default class Gui
{
	constructor()
	{	
		this.leftKeyDown = false;
		this.headerSvgUrl = "./svg/Pictorius_Logo_Header.svg";
		this.containerPictoriusLogoHeader = document.getElementById("container_pictorius_logo_header");
		this.containerPictoriusFoto = document.getElementById("container_pictorius_foto");

		this.headerSvg = null;

		this.menuBarColor = "#191f51"; // Marineblau
		this.menuOpacity = "93%";
		
		this.mouseEnterElementsWhiteIds = ["horizontal_menu_button_teachers", "horizontal_menu_button_students"];
		this.addHTMLHorizontalMenuIds = ["login_area_teacher", "login_area_student"];
		this.addHTMLHorizontalMenuPaths = ["./html/teacher_login_area.htm","./html/students_login_area.htm"];
		
		this.addHTMLHorizontalMenuInputFields = ["input_teacher_email", "input_password_teacher", "input_student_code"];
		this.verticalMenuButtons = [];
		
		this.pages = ["Uebersicht", "Fragebogen_erstellen", "Fragen_verwalten", "Klassen_verwalten"];
		this.pagesNames = ["./html/uebersicht.htm", "./html/fragebogen_erstellen.htm", "./html/fragen_verwalten.htm", "./html/klassen_verwalten.htm"];
		
		this.functionKeys = [];
		
		this.functionKeys['login_area_teacher'] = [];
		this.functionKeys['login_area_teacher'][0] = "login_area_teacher";

		this.functionKeys['login_area_student'] = [];
		this.functionKeys['login_area_student'][0] = "login_area_student";
		
		this.functionKeys['Uebersicht_page'] = [];
		this.functionKeys['Uebersicht_page'][0] = "Uebersicht_page_0";
		this.functionKeys['Uebersicht_page'][1] = "Uebersicht_page_event_0";
		
		this.functionKeys['Fragebogen_erstellen_page'] = [];
		this.functionKeys['Fragebogen_erstellen_page'][0] = "Fragebogen_erstellen_page_0";
		this.functionKeys['Fragebogen_erstellen_page'][1] = "Fragebogen_erstellen_page_1";
		this.functionKeys['Fragebogen_erstellen_page'][2] = "Fragebogen_erstellen_page_event_0";
		this.functionKeys['Fragebogen_erstellen_page'][4] = "Fragebogen_erstellen_page_event_2";
		
		this.functionKeys['Fragen_verwalten_page'] = [];
		this.functionKeys['Fragen_verwalten_page'][0] = "Fragen_verwalten_page_0";
		this.functionKeys['Fragen_verwalten_page'][1] = "Fragen_verwalten_page_1";
		this.functionKeys['Fragen_verwalten_page'][2] = "Fragen_verwalten_page_event_0";
		
		
		this.functionKeys['Klassen_verwalten_page'] = [];
		
		
		this.logoBackgroundRectangleHeight;
		
		this.containerHorizontalMenuBar;
		this.horizontalMenuBarWidth;
		this.horizontalMenuBarHeight;
		this.horizontalMenuBarButtonTeachers;
		this.horizontalMenuBarButtonStudents;
		
		this.containerVerticalMenuBar;
		this.verticalMenuBarWidth;
		this.verticalMenuBarHeight;

	}


	// Lädt das horizontale und vertikale Menü je nach Seite (index.php oder verwaltung.php)
	loadSvgAndMenus( pageType )
	{
		let containerPictoriusLogoHeader = this.containerPictoriusLogoHeader;
		let headerSvg = this.headerSvg;
		let mouseEnterElementsWhiteIds = this.mouseEnterElementsWhiteIds;
		let ids = this.addHTMLHorizontalMenuIds;
		let paths = this.addHTMLHorizontalMenuPaths;
		let inputFields = this.addHTMLHorizontalMenuInputFields;
		let pages = this.pages;
		let pagesNames = this.pagesNames;
		
		let xhttp = new XMLHttpRequest();
		
		xhttp.onreadystatechange = ()=>{
			if (xhttp.readyState == 4 && xhttp.status == 200)
			{
				containerPictoriusLogoHeader.innerHTML = xhttp.responseText;
				headerSvg = xhttp.responseText;
				
				this.initHorizontalMenu();
				
				// Event listener werden den Menübuttons hinzugefügt sobald der Hintergrund und die SVG geladen sind
				if (pageType == "index")
				{
					this.addEventsHorizontalMenu(mouseEnterElementsWhiteIds, "white", ids, paths, this.addHTML, this.functionMannager, this.functionKeys);
				}

				if (pageType == "verwaltung")
				{
					this.initVerticalMenu();
					this.initPageContainer();
					this.addEventsVerticalMenu(pages, pagesNames, this.functionMannager, this.functionKeys);

					// Initial-Page öffnen, Page-Button des vertikalen Menüs entsprechend einfärben
					// (Visibility der anderen Pages auf "invisible" stellen)
					document.onreadystatechange = this.openInitialPage("Uebersicht");
				}
			}
		};
		xhttp.open("POST", this.headerSvgUrl, true);
		xhttp.send();
	}
	
	
	// Initialisieren des horizontalen Menüs
	initHorizontalMenu()
	{
		this.horizontalMenuBarWidth = document.getElementById("headerHorizontalMenuBar").getBoundingClientRect().width;
		this.horizontalMenuBarHeight = document.getElementById("headerHorizontalMenuBar").getBoundingClientRect().height;
		this.logoBackgroundRectangleHeight = document.getElementById("logoBackgroundRectangle").getBoundingClientRect().height;
		
		this.verticalMenuBarWidth = document.getElementById("headerVerticalMenuBar").getBoundingClientRect().width;
		
		this.containerHorizontalMenuBar = document.getElementById("container_horizontal_menu");
		this.containerHorizontalMenuBar.style.width = this.horizontalMenuBarWidth + "px";
		this.containerHorizontalMenuBar.style.height = this.horizontalMenuBarHeight + "px";
		this.containerHorizontalMenuBar.style.left = this.verticalMenuBarWidth + "px";
		
		this.horizontalMenuBarButtonTeachers = document.getElementById("horizontal_menu_button_teachers");
		this.horizontalMenuBarButtonTeachers.style.width = this.horizontalMenuBarWidth / 2 + "px";
		this.horizontalMenuBarButtonTeachers.style.height = this.horizontalMenuBarHeight + "px";
		this.horizontalMenuBarButtonTeachers.style.lineHeight = this.horizontalMenuBarHeight + "px";
		
		this.horizontalMenuBarButtonStudents = document.getElementById("horizontal_menu_button_students");
		if (this.horizontalMenuBarButtonStudents != null)
		{
			this.horizontalMenuBarButtonStudents.style.width = this.horizontalMenuBarWidth / 2 + "px";
			this.horizontalMenuBarButtonStudents.style.height = this.horizontalMenuBarHeight + "px";
			this.horizontalMenuBarButtonStudents.style.left = this.horizontalMenuBarWidth / 2 + "px";
			this.horizontalMenuBarButtonStudents.style.lineHeight = this.horizontalMenuBarHeight + "px";
		}
	}
	
	
	// Initialisieren des vertikalen Menüs
	initVerticalMenu()
	{
		this.verticalMenuBarWidth = document.getElementById("headerVerticalMenuBar").getBoundingClientRect().width;
		this.verticalMenuBarHeight = document.getElementById("headerVerticalMenuBar").getBoundingClientRect().height;
		this.logoBackgroundRectangleHeight = document.getElementById("logoBackgroundRectangle").getBoundingClientRect().height;
		
		this.containerVerticalMenuBar = document.getElementById("container_vertical_menu");
		this.containerVerticalMenuBar.style.width = this.verticalMenuBarWidth + "px";
		this.containerVerticalMenuBar.style.height = (window.innerHeight - this.verticalMenuBarHeight - this.logoBackgroundRectangleHeight).toString() + "px";
		this.containerVerticalMenuBar.style.top = this.logoBackgroundRectangleHeight + this.verticalMenuBarHeight + 6 + "px";
		
		//this.containerVerticalMenuBar.style.backgroundColor = this.menuBarColor;
		//this.containerVerticalMenuBar.style.opacity = "90%";
	}
	

	// Initialisieren des page containers
	initPageContainer()
	{
		let horizontalMenuBarHeight = document.getElementById("headerHorizontalMenuBar").getBoundingClientRect().height;
		let verticalMenuBarWidth = document.getElementById("headerVerticalMenuBar").getBoundingClientRect().width;
		let containerPages = document.getElementById("container_pages");
		containerPages.style.top = horizontalMenuBarHeight + 8 + "px";
		containerPages.style.left = verticalMenuBarWidth + 8 + "px";
		containerPages.style.width = (window.innerWidth - verticalMenuBarWidth).toString() + "px";
		containerPages.style.height = (window.innerHeight - horizontalMenuBarHeight).toString() + "px";
		containerPages.style.backgroundColor = "white";
		containerPages.style.opacity = this.menuOpacity;
	}
	
	
	// Event listener zum Vergrößern des Bereichs und Nachladen von Input Feldern und Buttons
	addEventsHorizontalMenu(idArray, color, domIds, paths, paramFunction, functions, functionKeys)
	{
		let menuBarColor = this.menuBarColor;
		let logoBackgroundRectangleHeight = this.logoBackgroundRectangleHeight;
		let horizontalMenuBarHeight = this.horizontalMenuBarHeight;

		for(let i = 0; i < idArray.length; i++)
		{
			let element = document.getElementById(idArray[i]);
			element.leftKeyDown = false;

			if (element != null)
			{
				let originalBackgroundColor = element.style.backgroundColor;
				let originalHeight = element.style.height;
			
				element.addEventListener("mouseenter", function(){
					
						this.style.backgroundColor = color;
						this.style.color = menuBarColor;
						this.style.height = logoBackgroundRectangleHeight + "px";
						this.style.borderStyle = "solid";
						this.style.borderWidth = "1px";

						let child = document.getElementById(this.children[1].id);

						if(child.innerHTML.length < 100)
						{					
							paramFunction( domIds[i], paths[i], null, functions, functionKeys );
						}

				});
			

				element.addEventListener("mouseleave", ()=>{

					// Prüfung ob in einem Eingabefeld der Login Bereiche etwas eingegeben wurde. Ist dies der Fall wird dieser nicht ausgeblendet
					var inputArray = element.getElementsByTagName("input");

					var allInput = "";
        			for(let i = 0; i < inputArray.length; i++)
        			{
						allInput += document.getElementById(inputArray[i].id).value;
        			}

					if(allInput.length == 0)
					{	
						element.style.backgroundColor = originalBackgroundColor;
						element.style.color = color;
						element.style.height = originalHeight;
						element.style.borderStyle = "none";
		
						if (document.getElementById( domIds[i] ) != null) document.getElementById( domIds[i] ).innerHTML = "";
						
					}
				});					
			}

		}

	}
	
	
	// Aufbau des Verwaltungsmenüs (horizontales Menü)
	addEventsVerticalMenu(idArray, idArray2, functions, functionKeys)
	{	
		let pages = idArray;
		let pagesNames = idArray2;
		let containerVerticalMenu = document.getElementById("container_vertical_menu");
		let containerPages = document.getElementById("container_pages");
		let horizontalMenuBarHeight = document.getElementById("headerHorizontalMenuBar").getBoundingClientRect().height;
		let containerVerticalMenuBarHeight = parseInt( document.getElementById("container_vertical_menu").style.height);
		
		//let switchPageFunction = this.switchPage;
		let pagesArray = this.pages;
		let menuBarColor = this.menuBarColor;
		
		// Hinzufügen der Buttons fürs vertikale Menü
		for (let i = 0; i < pages.length; i++)
		{
			this.verticalMenuButtons[i] = document.createElement("div");
			this.verticalMenuButtons[i].id = pages[i] + "_button";
			this.verticalMenuButtons[i].className = "verticalMenuButton";
			
			let buttonName = pages[i].replace("Ue","Ü");
			buttonName = buttonName.replace("_"," ");
			this.verticalMenuButtons[i].innerHTML = "<div>" + buttonName + "</div>";
			
			this.verticalMenuButtons[i].style.backgroundColor = this.menuBarColor;
			this.verticalMenuButtons[i].style.opacity = this.menuOpacity;
			//this.verticalMenuButtons[i].style.whiteSpace = "pre";
			
			this.verticalMenuButtons[i].addEventListener("mousedown", ()=>{
				this.switchPage(pages[i], pagesArray, menuBarColor, functions, functionKeys);
			});
			
			containerVerticalMenu.appendChild(this.verticalMenuButtons[i]);
		}
		// Lückenfüller zum ausfüllen des restlichen Verwaltungsmenüs hinzufügen (Bereich von Unterkante-letzer-Button bis Page-Ende Marineblau ausfüllen)
		let spaceFiller = document.createElement("div");
		spaceFiller.id = "spaceFiller";
		spaceFiller.style.height = containerVerticalMenuBarHeight - (containerVerticalMenuBarHeight / 100 * 8 * pages.length) + "px";
		spaceFiller.style.backgroundColor = this.menuBarColor;
		spaceFiller.style.opacity = this.menuOpacity;
		
		containerVerticalMenu.appendChild(spaceFiller);
		
		// Hinzufügen der Pages fürs vertikale Menü
		for (let i = 0; i < pages.length; i++)
		{		
			let page = document.createElement("div");
			page.id = pages[i] + "_page";
			page.style.width = "100%";
			page.style.height = window.innerHeight - horizontalMenuBarHeight + "px";
			page.style.position = "absolute";
			this.addHTML(page.id, pagesNames[i], page, functions, functionKeys);
			
			containerPages.appendChild(page);
			
		}
		
	}

	openInitialPage(pageName)
	{
		let menuButton = document.getElementById(pageName + "_button");
		menuButton.style.backgroundColor = "white";
		menuButton.style.color = this.menuBarColor;
		menuButton.style.borderLeft = "5px solid " + this.menuBarColor;
		menuButton.style.fontWeight = "bold";


		for (let i = 0; i < this.pages.length; i++)
		{
			if (this.pages[i] == pageName) continue;

			let tempPage = document.getElementById(this.pages[i] + "_page");
			tempPage.style.visibility = "hidden";



		}
	}
	
	// Funktion zum Wechseln der Page
	switchPage(pageName, pagesArray, menuBarColor, functions, functionKeys)
	{
		// console.log("switchPage:");
		// console.log(pageName);
		for (let i = 0; i < pagesArray.length; i++)
		{
			let idPage = pagesArray[i] + "_page";
			let tempPage = undefined;
			if (document.getElementById(idPage) != null) tempPage = document.getElementById(idPage);
			
			var idButton = pagesArray[i] + "_button";
			let menuButton = document.getElementById(idButton);
			
			let bool = idPage.includes(pageName);
			
			if (!bool)
			{
				tempPage.style.visibility = "hidden";
				menuButton.style.backgroundColor = menuBarColor;
				menuButton.style.color = "white";
				menuButton.style.fontWeight = "normal";
			}
			else
			{
				tempPage.style.visibility = "visible";
				menuButton.style.backgroundColor = "white";
				menuButton.style.color = menuBarColor;
				menuButton.style.borderLeft = "5px solid " + menuBarColor;
				menuButton.style.fontWeight = "bold";
				
				for( var key in functionKeys[idPage] )
				{
					let functionName = functionKeys[idPage][key];
					
					if ( !functionName.includes("event") )
					{
						if ( typeof functions[functionName] == "function" ) functions[functionName]();						
					}
				}	
			}
		}
	}
	
	// Funktion um Daten nachzuladen und dem Bereich hinzuzufügen
	addHTML( domId, path, page, functions, functionKeys )
	{
		let xhttp = new XMLHttpRequest();
		var domElement = document.getElementById(domId);
		
		if (page != null) domElement = page;
		
		xhttp.onreadystatechange = ()=>{
			if (xhttp.readyState == 4 && xhttp.status == 200)
			{
				domElement.innerHTML = xhttp.responseText;
				
				for( var key in functionKeys[domId] )
				{
					let functionName = functionKeys[domId][key];
					
					if ( typeof functions[functionName] == "function" ) functions[functionName]();
				}
			}
		};
		if (domElement != null)
		{
			xhttp.open("POST", path, true);
			xhttp.send();
		}
	}
	
}