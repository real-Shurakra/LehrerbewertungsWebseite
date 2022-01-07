class language{
    setLanguage(strlanguage){
        question = new FormData();
        question.append('mode', mode);
        question.append('language', strlanguage);

    }

    getLanguage(){
        
    }

    readBrowserLanguage(){
        return 'de-de';
        //return navigator.language || navigator.userLanguage;
    }
}