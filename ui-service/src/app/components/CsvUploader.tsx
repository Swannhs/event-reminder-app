"use client";

import React, { useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { importCsv, clearMessages } from "../store/slice/csvSlice";
import { RootState, AppDispatch } from "../store/store";
import Link from "next/link";

export default function CsvUploader() {
    const dispatch = useDispatch<AppDispatch>();
    const { loading, successMessage, errorMessage } = useSelector((state: RootState) => state.csv);
    const [file, setFile] = useState<File | null>(null);

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.files && e.target.files[0]) {
            setFile(e.target.files[0]);
        }
    };

    const handleUpload = async () => {
        if (!file) return;
        const formData = new FormData();
        formData.append("csv_file", file);

        await dispatch(importCsv(formData));
        setFile(null);

        setTimeout(() => {
            dispatch(clearMessages());
        }, 5000);
    };

    return (
        <div className="mb-8 p-4 bg-gray-800 rounded-lg shadow-lg">
            <h2 className="text-lg font-semibold text-white mb-2">📁 Import CSV</h2>
            <div className='flex justify-between'>
                <div className="flex items-center space-x-4">
                    <input type="file" onChange={handleFileChange} className="mb-2 text-white" />
                    <button
                        onClick={handleUpload}
                        className="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded transition"
                        disabled={loading}
                    >
                        {loading ? "Uploading..." : "Upload CSV"}
                    </button>
                </div>
                <Link href="/event/create" className="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">
                    ➕ Add Event
                </Link>
            </div>
            {successMessage && <p className="text-green-400 mt-2">{successMessage}</p>}
            {errorMessage && <p className="text-red-400 mt-2">{errorMessage}</p>}
        </div>
    );
}
