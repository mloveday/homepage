import {Page} from "./Page";

export const startPageOption = 'START';

export class Book {
    public readonly entryPoint: Page;

    constructor(entryPoint: Page, pages: Map<string, Page>) {
        this.entryPoint = entryPoint;
        this.pages = pages;
    }

    public readonly pages: Map<string, Page>;
}