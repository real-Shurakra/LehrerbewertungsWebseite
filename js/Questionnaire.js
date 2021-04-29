// Klasse Questionnaire

export default class Questionnaire
{
	constructor(id, className, subject, amountStudents)
	{
		this.id = id;
		this.className = className;
		this.subject = subject;
		this.amountStudents = amountStudents;
		this.questions = [];
		this.currentStatus = "offline";
		this.year = 0;
	}
	
	addQuestion(question)
	{
		this.questions.push(question);
	}
	
	
}