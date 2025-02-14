export interface EventType {
    id: number;
    event_id: string;
    title: string;
    description: string;
    date_time: string;
    status: string;
    reminder_email?: string;
    created_at: string;
    updated_at: string;
}

export interface CreateEventType {
    title: string;
    description: string;
    date_time: string;
    status: string;
    reminder_email?: string;
}