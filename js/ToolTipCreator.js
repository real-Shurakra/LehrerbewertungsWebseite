// Klasse ToolTipCreator

export default class ToolTipCreator
{
	constructor()
	{
	}

	createToolTip()
	{
		let toolTipId = "toolTip";
		let toolTipWidth = 100;
		let toolTipHeight = 100;
		let toolTip = document.createElement("div");
		toolTip.id = toolTipId;
		toolTip.style.width = toolTipWidth + "px";
		toolTip.style.height = toolTipHeight + "px";
		toolTip.style.backgroundColor = "white";
		//toolTip.style.opacity = "99%";
		toolTip.style.position = "absolute";
		toolTip.style.zIndex = 10;
		toolTip.style.borderStyle ="solid";
		toolTip.style.borderRadius = "15px 15px 15px 15px";
		toolTip.style.borderWidth = "3px";
		toolTip.style.visibility = "hidden";
		toolTip.style.padding = "5px";
		toolTip.style.fontSize = "medium";

		toolTip.innerHTML = " \n l-click: one in \n r-click: all in";

		return toolTip;
	}
}