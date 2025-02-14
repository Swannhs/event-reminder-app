"use client";

import {useRouter} from "next/navigation";
import {useDispatch} from "react-redux";
import {AppDispatch} from "@/store/store";
import {addEvent} from "@/store/slice/eventSlice";
import EventForm from "@/components/EventForm";
import {CreateEventType} from "@/api/types/eventType";

export default function CreateEventPage() {
    const dispatch = useDispatch<AppDispatch>();
    const router = useRouter();

    const handleSubmit = async (eventData: CreateEventType) => {
        await dispatch(addEvent(eventData));
        router.push("/");
    };

    return (
        <div className="container mx-auto max-w-2xl p-6">
            <h1 className="text-3xl font-bold text-center mb-6">➕ Create New Event</h1>
            <EventForm onSubmit={handleSubmit}/>
        </div>
    );
}
