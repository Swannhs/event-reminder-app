"use client";

import {useEffect, useState} from "react";
import {useRouter, useParams} from "next/navigation";
import {useDispatch, useSelector} from "react-redux";
import {fetchEventById, editEvent} from "@/app/store/slice/eventSlice";
import {RootState, AppDispatch} from "@/app/store/store";
import EventForm from "@/app/components/EventForm";
import {CreateEventType} from "@/app/types/eventType";

export default function EditEventPage() {
    const {id} = useParams<{ id: string }>();
    const dispatch = useDispatch<AppDispatch>();
    const router = useRouter();
    const {selectedEvent, loading, error} = useSelector((state: RootState) => state.event);
    const [formData, setFormData] = useState<CreateEventType>();

    useEffect(() => {
        if (id) {
            dispatch(fetchEventById(Number(id)));
        }
    }, [dispatch, id]);

    useEffect(() => {
        if (selectedEvent) {
            setFormData({
                title: selectedEvent.title,
                description: selectedEvent.description,
                date_time: selectedEvent.date_time,
                status: selectedEvent.status,
                reminder_email: selectedEvent.reminder_email,
            });
        }
    }, [selectedEvent]);

    const handleSubmit = async (updatedData: CreateEventType) => {
        await dispatch(editEvent({id: Number(id), updatedData}));
        router.push(`/event/${id}`);
    };

    if (loading) return <p className="text-center text-gray-400">Loading...</p>;
    if (error) return <p className="text-center text-red-500">{error}</p>;
    if (!formData) return <p className="text-center text-gray-400">Event not found.</p>;

    return (
        <div className="container mx-auto max-w-2xl p-6">
            <h1 className="text-3xl font-bold text-center mb-6">✏ Edit Event</h1>
            <EventForm initialData={formData} onSubmit={handleSubmit}/>
        </div>
    );
}
