"use client";

import {useEffect} from "react";
import {useDispatch, useSelector} from "react-redux";
import {useParams} from "next/navigation";
import {fetchEventById} from "@/app/store/slice/eventSlice";
import {RootState, AppDispatch} from "@/app/store/store";
import Link from "next/link";

export default function EventViewPage() {
    const {id} = useParams<{ id: string }>();
    const dispatch = useDispatch<AppDispatch>();
    const {selectedEvent, loading, error} = useSelector((state: RootState) => state.event);

    useEffect(() => {
        if (id) {
            dispatch(fetchEventById(Number(id)));
        }
    }, [dispatch, id]);

    if (loading) return <p className="text-gray-400 text-center">Loading event details...</p>;
    if (error) return <p className="text-red-500 text-center">{error}</p>;
    if (!selectedEvent) return <p className="text-gray-400 text-center">Event not found.</p>;

    return (
        <div className="container mx-auto max-w-2xl p-6">
            <h1 className="text-3xl font-bold text-center mb-6">📅 Event Details</h1>

            <div className="bg-gray-800 p-6 rounded-lg shadow-lg space-y-4">
                <p className="text-blue-400 font-semibold">Event ID: {selectedEvent.event_id}</p>
                <h2 className="text-2xl font-semibold text-white">{selectedEvent.title}</h2>
                <p className="text-gray-300">{selectedEvent.description}</p>
                <p className="text-gray-400">
                    📅 <span
                    className="font-semibold">Date & Time:</span> {new Date(selectedEvent.date_time).toLocaleString()}
                </p>
                <p className={`mt-2 font-semibold ${selectedEvent.status === "completed" ? "text-green-400" : "text-yellow-400"}`}>
                    🏷 Status: {selectedEvent.status}
                </p>
                {selectedEvent.reminder_email && (
                    <p className="text-gray-300">📧 <span
                        className="font-semibold">Reminder Email:</span> {selectedEvent.reminder_email}</p>
                )}
                <p className="text-gray-500 text-sm">
                    🕒 <span
                    className="font-semibold">Created:</span> {new Date(selectedEvent.created_at).toLocaleString()}
                </p>
                <p className="text-gray-500 text-sm">
                    🔄 <span
                    className="font-semibold">Last Updated:</span> {new Date(selectedEvent.updated_at).toLocaleString()}
                </p>
            </div>

            <div className="flex justify-between mt-6">
                <Link href="/" className="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    ⬅ Back to Events
                </Link>

                <Link href={`/event/${selectedEvent.id}/edit`}
                      className="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    ✏ Edit Event
                </Link>
            </div>
        </div>
    );
}
