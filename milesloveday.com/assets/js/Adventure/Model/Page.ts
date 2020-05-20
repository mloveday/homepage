export class Page {
    public readonly description: string;
    public readonly progressionOptions: Map<string, string>;
    public readonly isSuccess: boolean;
    public readonly isFailure: boolean;

    constructor(description: string, progressionOptions: Map<string, string>, isSuccess: boolean, isFailure: boolean) {
        this.description = description;
        this.progressionOptions = progressionOptions;
        this.isSuccess = isSuccess;
        this.isFailure = isFailure;
    }
}