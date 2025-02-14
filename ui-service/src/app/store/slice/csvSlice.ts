import { createSlice, createAsyncThunk, PayloadAction } from "@reduxjs/toolkit";
import { apiClient } from "../../api/eventApi";

export const importCsv = createAsyncThunk("csv/importCsv", async (formData: FormData) => {
    const response = await apiClient.post("/event-reminders/import", formData, {
        headers: { "Content-Type": "multipart/form-data" },
    });
    return response.data;
});

interface CsvState {
    loading: boolean;
    successMessage: string | null;
    errorMessage: string | null;
}

const initialState: CsvState = {
    loading: false,
    successMessage: null,
    errorMessage: null,
};

const csvSlice = createSlice({
    name: "csv",
    initialState,
    reducers: {
        clearMessages(state) {
            state.successMessage = null;
            state.errorMessage = null;
        },
    },
    extraReducers: (builder) => {
        builder
            .addCase(importCsv.pending, (state) => {
                state.loading = true;
            })
            .addCase(importCsv.fulfilled, (state, action: PayloadAction<{ success: boolean; message: string }>) => {
                state.loading = false;
                if (action.payload.success) {
                    state.successMessage = action.payload.message;
                } else {
                    state.errorMessage = action.payload.message;
                }
            })
            .addCase(importCsv.rejected, (state, action) => {
                state.loading = false;
                state.errorMessage = action.error.message ?? "CSV import failed.";
            });
    },
});

export const { clearMessages } = csvSlice.actions;
export default csvSlice.reducer;
