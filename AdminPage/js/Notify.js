/**
 * @brief Making easy bootrap modal popups
 */
class Notify{
    /**
     * @brief Constructor
     */
	constructor(){
		//console.log('Notify is now startup.')
        this.buttonType = Object.freeze({
            none : 'btn',
            primary : "btn btn-primary",
            secondary : "btn btn-secondary",
            success : "btn btn-success",
            info : "btn btn-info",
            warning : "btn btn-warning",
            danger : "btn btn-danger",
            dark : "btn btn-dark",
            light : "btn btn-light",
            link : "btn btn-link"
        })
		this.noteType = Object.freeze({
			erfolg : '<div class="alert alert-success" role="alert">',
			hinweis : '<div class="alert alert-info" role="alert">',
			warnung : '<div class="alert alert-warning" role="alert">',
			fehler : '<div class="alert alert-danger" role="alert">'
		});
        this.sizeType = Object.freeze({
            small : 'modal-sm',
            medium : 'modal-lg',
            large : 'modal-xl'
        })
		this.text = 'Something happend!';
        this.type = this.noteType.hinweis;
        this.size = this.sizeType.small;
        this.backgroundColor = '#C7C7C7';
        this.button = this.buttonType.secondary;
		//console.log('Notify is currently running.')
	}
	
    /**
     * @brief change popup text
     * @param {string} text The dixt to display in the popup
     */
	changeModalText(text){
		//console.log('notify.js => Notyfy.setText() -> Start')
		this.text = text;
	}

    /**
     * @brief chage popup type
     * @param {noteType} type The type of the popup
     */
    changeModalType(type){
        this.type = type;
    }

    /**
     * @brief changing popup size
     * @param {sizeType} size new popup size
     */
    changeModalSize(size){
        this.size = size;
    }

    /**
     * @breif changing popup color
     * @param {string} color Color HEX value
     */
    changeModalColor(color){
        this.backgroundColor = color;
    }
	
    /**
     * @brief constructing the popup and load to side
     * @param {sizeType} size The size of the popup
     */
	makeModal(){
		//console.log('notify.js => Notyfy.makeModal() -> Start')
		document.getElementById('notifyDiv').innerHTML=`
<div class="modal fade" id="notify">
	<div class="modal-dialog `+this.size+`">
		<div class="modal-content">
			<div class="modal-body" style="background-color: `+this.backgroundColor+`">
				<form class="form-inline" action="/action_page.php">
                    `+this.type+this.text+`</div>
				</form>
			</div>
			<button type="button" class="`+this.button+`" data-dismiss="modal">OK</button>
		</div>
	</div>
</div>`;
	}
	
    /**
     * @brief Shows the popup
     */
	showModal(){
		//console.log('notify.js => Notyfy.showModal() -> Start')
		$('#notify').modal('show');
	}
	
    /**
     * @brief Hides the popup
     */
	hideModal(){
		//console.log('notify.js => Notyfy.hideModal() -> Start')
		$('#notify').modal('hide');
	}
	
    /**
     * @brief Deletes the popup content
     */
	deleteModal(){
		//console.log('notify.js => Notyfy.deleteModal() -> Start')
		document.getElementById('notifyDiv').innerHTML='';
	}
}