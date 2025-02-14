import React from "react";
import {useDispatch} from "react-redux";
import {deleteEvent} from "@/store/slice/eventSlice";
import Link from "next/link";
import {AppDispatch} from "@/store/store";

interface EventProps {
    event: {
        id: number;
        title: string;
        description: string;
        date_time: string;
        status: string;
        reminder_email?: string;
    };
}

const EventCard: React.FC<EventProps> = ({event}) => {
    const dispatch = useDispatch<AppDispatch>();

    const handleDeleteEvent = async () => {
        await dispatch(deleteEvent(event.id))
    }

    return (
        <div key={event.id} className="bg-gray-800 p-5 rounded-lg shadow-lg">
            <h2 className="text-xl font-semibold line-clamp-1 mb-2">{event.title}</h2>
            <p className="text-gray-300 line-clamp-2 mb-2">{event.description}</p>
            <p className="text-gray-400">{new Date(event.date_time).toLocaleString()}</p>
            <p className={`mt-2 font-semibold uppercase ${event.status === "completed" ? "text-green-400" : "text-yellow-400"}`}>
                {event.status}
            </p>
            <div className='flex justify-between'>
                <Link href={`/event/${event.id}`} className="text-blue-500 hover:text-blue-300 mt-4 inline-block">
                    🔍 View Details
                </Link>
                <button
                    onClick={handleDeleteEvent}
                    className="mt-4 border-2 border-red-500 hover:bg-red-700 text-white font-semibold px-3 py-1 rounded transition"
                >
                    🗑️ Delete
                </button>
            </div>
        </div>
    )
};

export default EventCard;
