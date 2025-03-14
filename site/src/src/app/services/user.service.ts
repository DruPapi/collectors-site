import { Injectable } from "@angular/core";
import { LoggedInUserModel, LoggedInUserInterface } from "../models/user.model";
import { Observable, shareReplay } from "rxjs";
import { HttpClient } from "@angular/common/http";
import { CartService } from "./cart.service";

@Injectable({
    providedIn: 'root'
})
export class UserService  {
    private currentUser: LoggedInUserModel | null = null;
    private request$!: Observable<any>;

    constructor(
        private http: HttpClient,
        private cart: CartService
    ) {
        this.init();
    }

    init() {
        this.http.get<LoggedInUserInterface>('api/auth/me').subscribe({
            next: loggedInUser => {
                this.currentUser = new LoggedInUserModel(loggedInUser.item);
            }
        })
    }

    login(credentials: object): Observable<LoggedInUserInterface> {
        if (!this.request$) {
            this.request$ = this.http.post<LoggedInUserInterface>('/api/auth/login', credentials).pipe(
                shareReplay(1)
            );

            this.request$.subscribe({next: loggedInUser => {
                this.currentUser = new LoggedInUserModel(loggedInUser.item);
                this.cart.load();
            }})
        }

        return this.request$;
    }

    getUser(): LoggedInUserModel | null {
        return this.currentUser;
    }

    logout() {
        this.http.post('/api/auth/logout', []).subscribe({
            next: _ => {
                this.currentUser = null;
                this.cart.load();
            },
        })
    }
}
