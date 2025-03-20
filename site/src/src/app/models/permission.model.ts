export class PermissionModel {
    id!: number;
    name!: string;
    module!: string;
    permission!: string;
    constructor(source: Partial<PermissionModel>) {
        this.id = source.id || 0;
        this.name = source.name || '';
        this.module = source.module || '';
        this.permission = source.permission || '';
    }

    static createBatch(permissions: PermissionModel[]): PermissionModel[] {
        let result: PermissionModel[] = [];
        permissions.forEach(permission => result.push(new PermissionModel(permission)));
        return result;
    }
}
