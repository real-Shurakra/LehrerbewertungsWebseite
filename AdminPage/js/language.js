class language{
    setLanguage(strlanguage){
        
        question = new FormData();
        question.append('mode', mode);
        question.append('language', strlanguage);

    }

    getLanguage(){
        
    }

    readBrowserLanguage(){
        return navigator.language || navigator.userLanguage;
    }
}