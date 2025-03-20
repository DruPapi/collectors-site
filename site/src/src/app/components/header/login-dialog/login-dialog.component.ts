import { ChangeDetectionStrategy, Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Credentials } from "../../../models/user.model";
import { UserService } from "../../../services/user.service";
import { MatDialogRef } from "@angular/material/dialog";

@Component({
    selector: 'login-dialog-component',
    templateUrl: 'login-dialog.component.html',
    styleUrls: ['login-dialog.component.scss'],
    changeDetection: ChangeDetectionStrategy.OnPush,
})
export class LoginDialogComponent implements OnInit {
    loginForm!: FormGroup;

    constructor(
        private dialogRef: MatDialogRef<LoginDialogComponent>,
        private builder: FormBuilder,
        private userService: UserService,
    ) {}

    ngOnInit() {
        this.loginForm = this.builder.group({
            email: ['', Validators.required],
            password: ['', Validators.required],
        });
    }

    onSubmit() {
        if (!this.loginForm || this.loginForm.invalid) {
            console.log('Form is invalid');
            return;
        }

        let credentials: Credentials = {
            email: this.loginForm.get('email')?.value,
            password: this.loginForm.get('password')?.value,
        }

        this.userService.login(credentials).subscribe({
            next: () => {
                this.dialogRef.close();
            },
            error: err => {}
        });

        const formData = this.loginForm.value;
    }
}
