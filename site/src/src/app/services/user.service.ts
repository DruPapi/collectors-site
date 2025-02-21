import { Injectable } from "@angular/core";
import { LoggedinUserModelInterface } from "../models/user.model";

@Injectable({
    providedIn: 'root'
})
export class UserService {
    private currentUser: LoggedinUserModelInterface | null = null;
}
