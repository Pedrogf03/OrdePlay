export interface Game {
    id: number;
    name: string;
    total_rating?: number;
    first_release_date?: number; 
    cover?: {
        id: number;
        url: string;
    };
}