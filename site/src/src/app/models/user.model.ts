import { PermissionModel } from "./permission.model";

export interface LoggedInUserInterface {
    item: LoggedInUserModel;
}

export class LoggedInUserModel {
    id!: number;
    name!: string;
    permissions!: PermissionModel[];
    constructor(source: Partial<LoggedInUserModel>) {
        this.id = source.id || 0;
        this.name = source.name || '';
        this.permissions = PermissionModel.createBatch(source.permissions || []);
    }

    can(module: string, permission: string): boolean {
        return false;
    }
}

export interface Credentials {
    email: string;
    password: string;
}
