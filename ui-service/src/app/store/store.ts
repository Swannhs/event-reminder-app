import { configureStore } from "@reduxjs/toolkit";
import eventReducer from "./slice/eventSlice";
import csvReducer from "./slice/csvSlice";

export const store = configureStore({
    reducer: {
        event: eventReducer,
        csv: csvReducer,
    },
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;
