class Beep{

    constructor(idSelector) {
        this.audio = document.getElementById(idSelector);
    }

    stop(){
        this.audio.pause();
    }

    play(){
        this.audio.play();
    }

}

export default Beep;
