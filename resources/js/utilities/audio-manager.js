class Beep{

    constructor(idSelector) {
        this.audio = document.getElementById(idSelector);
    }

    stop(){
        this.audio.stop();
    }

    play(){
        this.audio.play();
        console.log('playing');
    }

    pause(){
        this.audio.pause();
    }
}

export default Beep;
