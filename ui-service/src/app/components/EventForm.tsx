"use client";

import React, { useState } from "react";
import {CreateEventType} from "@/app/types/eventType";

interface EventFormProps {
    initialData?: CreateEventType;
    onSubmit: (data: CreateEventType) => void;
}

export default function EventForm({ initialData, onSubmit }: EventFormProps) {
    const [formData, setFormData] = useState(
        initialData || {
            title: "",
            description: "",
            date_time: "",
            status: "upcoming",
            reminder_email: ""
        }
    );

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        onSubmit(formData);
    };

    return (
        <form onSubmit={handleSubmit} className="bg-gray-800 p-6 rounded-lg shadow-lg space-y-4">
            <input
                type="text"
                name="title"
                placeholder="Event Title"
                className="w-full p-3 rounded bg-gray-700 border border-gray-600"
                value={formData.title}
                onChange={handleChange}
                required
            />
            <textarea
                name="description"
                placeholder="Event Description"
                className="w-full p-3 rounded bg-gray-700 border border-gray-600"
                value={formData.description}
                onChange={handleChange}
            />
            <input
                type="datetime-local"
                name="date_time"
                className="w-full p-3 rounded bg-gray-700 border border-gray-600"
                value={formData.date_time}
                onChange={handleChange}
                required
            />
            <select
                name="status"
                className="w-full p-3 rounded bg-gray-700 border border-gray-600"
                value={formData.status}
                onChange={handleChange}
            >
                <option value="upcoming">Upcoming</option>
                <option value="completed">Completed</option>
            </select>
            <input
                type="email"
                name="reminder_email"
                placeholder="Reminder Email"
                className="w-full p-3 rounded bg-gray-700 border border-gray-600"
                value={formData.reminder_email}
                onChange={handleChange}
            />
            <button type="submit" className="w-full bg-blue-500 hover:bg-blue-700 text-white p-3 rounded">
                {initialData ? "Update Event" : "Add Event"}
            </button>
        </form>
    );
}
