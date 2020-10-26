import Types from "../types/global-types";

const bodyElement = document.querySelector('body');

function setGlobalType(type){
    clearGlobalTypes();
    bodyElement.classList.add('global-'+type);
}

function clearGlobalTypes(){
    bodyElement.classList.forEach(function(item){
        if(item.includes('global-'))
            bodyElement.classList.remove(item);
    });
}

function pauseToggle(){
    bodyElement.classList.toggle('pause');
}

function releasePause(){
    bodyElement.classList.remove('pause');
}

function hasType(type){
    return bodyElement.classList.contains('global-'+type);
}

export default {
    setGlobalType,
    clearGlobalTypes,
    pauseToggle,
    releasePause,
    hasType,
    Types
};
