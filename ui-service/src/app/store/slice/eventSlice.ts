import {createSlice, createAsyncThunk, PayloadAction} from "@reduxjs/toolkit";
import {apiClient} from "../../api/eventApi";
import {CreateEventType, EventType} from "../../types/eventType";

interface PaginationMeta {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface EventState {
    events: EventType[];
    selectedEvent: EventType | null;
    loading: boolean;
    error: string | null;
    pagination: PaginationMeta;
}

const initialState: EventState = {
    events: [],
    selectedEvent: null,
    loading: false,
    error: null,
    pagination: {
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
    },
};

const eventSlice = createSlice({
    name: "events",
    initialState,
    reducers: {
        setPage(state, action: PayloadAction<number>) {
            state.pagination.current_page = action.payload;
        },
    },
    extraReducers: (builder) => {
        builder
            .addCase(fetchEvents.pending, (state) => {
                state.loading = true;
            })
            .addCase(fetchEvents.fulfilled, (state, action) => {
                state.loading = false;
                state.events = action.payload.data;
                state.pagination = action.payload.meta;
            })
            .addCase(fetchEvents.rejected, (state, action) => {
                state.loading = false;
                state.error = action.error.message ?? "Error fetching events";
            })
            .addCase(fetchEventById.pending, (state) => {
                state.loading = true;
                state.selectedEvent = null;
            })
            .addCase(fetchEventById.fulfilled, (state, action: PayloadAction<EventType>) => {
                state.loading = false;
                state.selectedEvent = action.payload;
            })
            .addCase(fetchEventById.rejected, (state, action) => {
                state.loading = false;
                state.error = action.error.message ?? "Error fetching event";
            })
            .addCase(addEvent.fulfilled, (state, action: PayloadAction<{ data: EventType }>) => {
                state.events.push(action.payload.data);
            })
            .addCase(editEvent.fulfilled, (state, action: PayloadAction<EventType>) => {
                state.events = state.events.map((event) =>
                    event.id === action.payload.id ? action.payload : event
                );
                if (state.selectedEvent && state.selectedEvent.id === action.payload.id) {
                    state.selectedEvent = action.payload;
                }
            })
            .addCase(deleteEvent.fulfilled, (state, action: PayloadAction<number>) => {
                state.events = state.events.filter((event) => event.id !== action.payload);
            });
    },
});


export const fetchEvents = createAsyncThunk(
    "events/fetchEvents",
    async (page: number = 1) => {
        const response = await apiClient.get(`/event-reminders?page=${page}&limit=10`);
        return response.data;
    }
);

export const fetchEventById = createAsyncThunk(
    "events/fetchEventById",
    async (id: number) => {
        const response = await apiClient.get(`/event-reminders/${id}`);
        return response.data.data;
    }
);

export const addEvent = createAsyncThunk("events/addEvent", async (eventData: CreateEventType) => {
    const response = await apiClient.post("/event-reminders", eventData);
    return response.data;
});

export const editEvent = createAsyncThunk(
    "events/editEvent",
    async ({id, updatedData}: { id: number; updatedData: Partial<CreateEventType> }) => {
        const response = await apiClient.put(`/event-reminders/${id}`, updatedData);
        return response.data.data;
    }
);

export const deleteEvent = createAsyncThunk<number, number>("events/deleteEvent", async (id) => {
    await apiClient.delete(`/event-reminders/${id}`);
    return id;
});

export const {setPage} = eventSlice.actions;
export default eventSlice.reducer;
