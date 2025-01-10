import {Component, Directive, HostListener} from "@angular/core";

@Directive()
export abstract class BaseComponent {
    screenWidth: number;
    sidenavOpened: boolean;
    sidenavMode: "over" | "push" | "side";
    @HostListener('window:resize', ['$event'])
    handleResize(event: Event) {
        console.log('resize', event);
        this.screenWidth = window.innerWidth;
        this.resetSidenavValues();
    }

    constructor() {
        this.screenWidth = window.innerWidth;
        this.sidenavOpened = this.screenWidth > 840;
        this.sidenavMode = this.sidenavOpened ? "side" : "over";
    }

    private resetSidenavValues(): void {
        this.sidenavOpened = this.screenWidth > 840;
        this.sidenavMode = this.sidenavOpened ? "side" : "over";
    }
}
