import React, { useEffect, useState } from 'react';
import { formatDate } from '@fullcalendar/core';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
import axios from 'axios';

const RESOURCES = [
  { id: 'a', title: 'Auditorium A' },
  { id: 'b', title: 'Auditorium B', eventColor: 'green' },
  { id: 'c', title: 'Auditorium C', eventColor: 'orange' },
  { id: 'e', title: 'Auditorium E', eventColor: 'red' },
];

const DemoApp = () => {
  const [weekendsVisible, setWeekendsVisible] = useState(true);
  const [currentEvents, setCurrentEvents] = useState([]);

  const handleWeekendsToggle = () => {
    setWeekendsVisible(!weekendsVisible);
  };

  useEffect(() => {
    axios
      .get('http://127.0.0.1:8000/api/get_planed_posts')
      .then(response => {
        const events = response.data.map(event => ({
          id: event.id,
          title: event.title,
          start: new Date(event.start).toISOString().replace(/T.*$/, ''),
          // resourceId: 'a',
        }));

        setCurrentEvents(events);
      })
      .catch(error => {
        console.error('Error retrieving events:', error);
      });
  }, []);

  const handleEventClick = (clickInfo) => {
    if (window.confirm(`Are you sure you want to delete the event '${clickInfo.event.title}'`)) {
      clickInfo.event.remove();
    }
  };

  const renderEventContent = (eventInfo) => {
    return (
      <>
        <b>{eventInfo.timeText}</b>
        <i>{eventInfo.event.title}</i>
      </>
    );
  };

  const renderSidebarEvent = (event) => {
    return (
      <li key={event.id}>
        <b>
          {formatDate(event.start, { year: 'numeric', month: 'short', day: 'numeric' })}
        </b>
        <i>{event.title}</i>
      </li>
    );
  };

  return (
    <div className="demo-app">
      <div className="demo-app-main">
        <FullCalendar
          plugins={[dayGridPlugin, timeGridPlugin, resourceTimelinePlugin]}
          headerToolbar={{
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek',//resourceTimelineDay
          }}
          selectable={true}
          dayMaxEvents={true}
          weekends={weekendsVisible}
          events={currentEvents}
          eventContent={renderEventContent}
          eventClick={handleEventClick}
        />
      </div>
    </div>
  );
};

export default DemoApp;
