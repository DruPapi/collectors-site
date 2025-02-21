import { ChangeDetectionStrategy, Component, inject } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatDialog, MatDialogModule } from '@angular/material/dialog';

@Component({
    selector: 'login-dialog-component',
    templateUrl: 'login-dialog.component.html',
    changeDetection: ChangeDetectionStrategy.OnPush,
})
export class LoginDialogContent {
}
