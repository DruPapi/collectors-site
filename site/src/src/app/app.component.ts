import { Component } from '@angular/core';
import translationsHU from "../public/i18n/hu.json";
import { TranslateService } from "@ngx-translate/core";

@Component({
  selector: 'app-root',
  template: `
   <app-header></app-header>
   <router-outlet></router-outlet>
  `,
  styles: []
})
export class AppComponent {
  title = 'collection';

  constructor(private translate: TranslateService) {
    translate.setTranslation('hu', translationsHU);
    translate.setDefaultLang('hu');
  }
}
