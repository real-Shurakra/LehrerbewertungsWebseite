class interface{
    /**
     * @brief 
     * @param {FormData} formData The FormData question you want to send to PHP. Don't forget the 'mode' parameter
     */
    sendToPhp(formData){
        try {
            let xmlRequest = new XMLHttpRequest();
            xmlRequest.open('../php/main.php', false);
            xmlRequest.send(formData);
            let answer = xmlRequest.responseText();
            answer = JSON.parse(answer)
        } catch (error) {
            
        }
    }

    /**
     * @brief 
     * @param {string} filename The name of the file witch content you want to load. Don't write file ending. Exaple: 'mainMenu' not 'mainMenu.phph'
     * @returns {string} HTML formated string
     */
    loadTemplate(filename){
        try {
            let xmlRequest = new XMLHttpRequest();
            xmlRequest.open('../templates/'+filename+'.php');
            xmlRequest.send();
            return xmlRequest.responseText();
        } catch (error) {
            
        }
    }

    /**
     * 
     * @param {string} filename The name of the file witch content you want to load. Don't write file ending. Exaple: 'mainMenu' not 'mainMenu.phph'
     * @param {FormData} templateVars Associative array with variables of the template
     * @returns {string} HTML formated string
     */
    loadTemplateWithVariables(filename, templateVars){
        try {
            let xmlRequest = new XMLHttpRequest();
            xmlRequest.open('../templates/'+filename+'.php');
            xmlRequest.send(templateVars);
            return xmlRequest.responseText();
        } catch (error) {
            
        }
    }
}