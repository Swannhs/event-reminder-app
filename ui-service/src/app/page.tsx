"use client";

import {useEffect} from "react";
import {useDispatch, useSelector} from "react-redux";
import {fetchEvents, setPage} from "@/store/slice/eventSlice";
import {RootState, AppDispatch} from "@/store/store";
import EventCard from "@/components/EventCard";
import CsvUploader from "@/components/CsvUploader";

export default function HomePage() {
    const dispatch = useDispatch<AppDispatch>();
    const {events, loading, error, pagination} = useSelector((state: RootState) => state.event);
    const {current_page, last_page} = pagination;

    useEffect(() => {
        dispatch(fetchEvents(current_page));
    }, [dispatch, current_page]);

    return (
        <div className="container mx-auto p-6">
            <h1 className="text-4xl font-bold text-center mb-6">📅 Event Reminder App</h1>

            <CsvUploader/>

            <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {loading ? (
                    <p className="text-yellow-400 text-center">Loading events...</p>
                ) : error ? (
                    <p className="text-red-500 text-center">{error}</p>
                ) : events.length > 0 ? (
                    events.map((event) => <EventCard event={event} key={event.id}/>)
                ) : (
                    <p className="text-gray-400 text-center col-span-3">No events found.</p>
                )}
            </div>

            <div className="flex justify-between mt-6">
                <button
                    onClick={() => dispatch(setPage(current_page - 1))}
                    className={`px-4 py-2 bg-gray-700 rounded ${current_page === 1 ? "opacity-50 cursor-not-allowed" : "hover:bg-gray-600"}`}
                    disabled={current_page === 1}
                >
                    ⬅ Previous
                </button>

                <p className="text-gray-400">Page {current_page} of {last_page}</p>

                <button
                    onClick={() => dispatch(setPage(current_page + 1))}
                    className={`px-4 py-2 bg-gray-700 rounded ${current_page === last_page ? "opacity-50 cursor-not-allowed" : "hover:bg-gray-600"}`}
                    disabled={current_page === last_page}
                >
                    Next ➡
                </button>
            </div>
        </div>
    );
}
