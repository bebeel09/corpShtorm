! function (e) {

    "use strict";
    var t = function () {
        this.$body = e("body"),
            this.$modal = e("#event-modal"),
            this.$event = "#external-events div.external-event",
            this.$calendar = e("#calendar"),
            this.$saveCategoryBtn = e(".save-category"),
            this.$categoryForm = e("#add-category form"),
            this.$extEvents = e("#external-events"),
            this.$calendarObj = null
    };

    t.prototype.onDrop = function (t, n) {
        var a = t.data("eventObject"),
            o = t.attr("data-class"),
            i = e.extend({}, a);
        i.start = n,
            o && (i.className = [o]),
            this.$calendar.fullCalendar("renderEvent", i, !0),
            e("#drop-remove").is(":checked"), t.remove()
    },

        t.prototype.onEventClick = function (t, n, a) {

            var o = this,
                i = e("<form></form>");
            i.append("<label>Название события</label>"),
                i.append("<div class='input-group'><input class='form-control' type=text value='" + t.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success waves-effect waves-light'><i class='fa fa-check'></i> Сохранить</button></span></div>"),
                o.$modal.modal({
                    backdrop: "static"
                }),
                o.$modal.find(".modal-title").empty().prepend("Изменить событие");
            o.$modal.find(".delete-event").show().end().find(".save-event").hide().end().find(".modal-body").empty().prepend(i).end().find(".delete-event").unbind("click").on("click", function () {
                o.$calendarObj.fullCalendar("removeEvents", function (e) {
                    //здесь аякс на удаление
                    $.ajax({
                        headers: {
                            'X-CSRF-Token': token
                        },
                        type: "POST",
                        url: urlRouteDelete,
                        data: { "id": t.id },
                        error: function (jqXhr, json, errorThrown) {
                            console.log('NO Успех');
                        }
                    });

                    return e._id == t._id
                }),
                    o.$modal.modal("hide")
            }),
                o.$modal.find("form").on("submit", function () {

                    t.title = i.find("input[type=text]").val();
                    // аякс на обновление
                    $.ajax({
                        headers: {
                            'X-CSRF-Token': token
                        },
                        type: "POST",
                        url: urlRouteUpdate,
                        data: { "title": t.title, "id": t.id },
                        error: function (jqXhr, json, errorThrown) {
                            console.log('NO Успех');
                        }
                    });

                    o.$calendarObj.fullCalendar("updateEvent", t);
                    o.$modal.modal("hide");
                    return !1
                })

        },

        t.prototype.onSelect = function (t, n, a) {
            var o = this;
            o.$modal.modal({
                backdrop: "static"
            });
            o.$modal.find(".modal-title").empty().prepend("Добавить новое событие");
            var i = e("<form></form>");
            i.append("<div class='row'></div>"), 
            i.find(".row").append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Название события</label><input class='form-control' placeholder='Название события' type='text' name='title'/></div></div>").append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Категории</label><select class='form-control' name='category'></select></div></div>").find("select[name='category']").append("<option data-repeats='1' value='bg-success'>Ежемесячное</option>").append("<option data-repeats='0' value='bg-primary'>Важное</option>").append("<option data-repeats='2' value='bg-pink'>День рождения</option>").append("<option data-repeats='0' value='bg-info'>Новость</option>"),
                o.$modal.find(".delete-event").hide().end().find(".save-event").show().end().find(".modal-body").empty().prepend(i).end().find(".save-event").unbind("click").on("click", function () {
                    i.submit()
                }),
                o.$modal.find("form").on("submit", function () {
                    var e = i.find("input[name='title']").val(),
                        a = (i.find("input[name='beginning']").val(),
                            i.find("input[name='ending']").val(),
                            i.find("select[name='category'] option:checked").val()),
                        b = i.find("select[name='category'] option:checked")[0].dataset.repeats;
                            
                    var data = {
                        title: e,
                        start: t,
                        end: n,
                        className: a,
                        repeats: b
                    };
                    // Здесь аякс на добавление
                    if (null !== e && 0 != e.length) {
                        $.ajax({
                            headers: {
                                'X-CSRF-Token': token
                            },
                            type: "POST",
                            url: urlRouteAdd,
                            data: { "data": JSON.stringify(data) },
                            success: function (jqXhr, json, errorThrown) {
                                o.$calendarObj.fullCalendar("renderEvent", {
                                    id: jqXhr,
                                    title: e,
                                    start: t,
                                    end: n,
                                    allDay: !1,
                                    className: a,
                                    repeats: b
                                });
                            },
                            error: function (jqXhr, json, errorThrown) {
                                console.log('NO Успех');
                            }
                        });
                    }
                    return null !== e && 0 != e.length ? ((!0), o.$modal.modal("hide")) : alert("Нельзя добавить событие без названия"), !1
                }),
                o.$calendarObj.fullCalendar("unselect")
        },

        t.prototype.enableDrag = function () {
            e(this.$event).each(function () {
                var t = {
                    title: e.trim(e(this).text())
                };
                e(this).data("eventObject", t), e(this).draggable({
                    zIndex: 999,
                    revert: !0,
                    revertDuration: 0
                })
            })
        },

        t.prototype.init = function () {
            this.enableDrag();
            // var t = new Date,
            // n = (t.getDate(), t.getMonth(), t.getFullYear(), new Date(e.now())),

            // eventData = [{
            //     title: "Hey!",
            //     start: new Date(e.now() + 158e6),
            //     className: "bg-dark"
            // }, {
            //     title: "See John Deo",
            //     start: n,
            //     end: n,
            //     className: "bg-danger"
            // }, {
            //     title: "Buy a Theme",
            //     start: new Date(e.now() + 338e6),
            //     className: "bg-primary"
            // },{
            //     id: 222,
            //     title: 'Birthday Party',
            //     start: '2017-02-04T07:00:00',
            //     description: 'This is a cool event',
            //     className: 'scheduler_basic_event',
            //     repeat: 2
            // }],
            var o = this;

            // Any value represanting monthly repeat flag
            var REPEAT_MONTHLY = 1;
            // Any value represanting yearly repeat flag
            var REPEAT_YEARLY = 2;

            o.$calendarObj = o.$calendar.fullCalendar({
                slotDuration: "00:15:00",
                minTime: "08:00:00",
                maxTime: "19:00:00",
                defaultView: "month",
                handleWindowResize: !0,
                height: e(window).height() - 200,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "month"
                },
                // resources: eventData,
                events: eventData,
                editable: 0,
                droppable: 0,
                eventLimit: 3,
                selectable: !0,
                eventDurationEditable: !1,
                // Позволяет повторять события
                dayRender: function (date, cell) {
                    // Get all events
                    var events = o.$calendar.fullCalendar('clientEvents').length ? o.$calendar.fullCalendar('clientEvents') : eventData;
                    // Start of a day timestamp
                    var dateTimestamp = date.hour(0).minutes(0);
                    var recurringEvents = new Array();

                    // find all events with monthly repeating flag, having id, repeating at that day few months ago  
                    var monthlyEvents = events.filter(function (event) {
                        return event.repeats === REPEAT_MONTHLY &&
                            event.id &&
                            moment(event.start).hour(0).minutes(0).diff(dateTimestamp, 'months', true) % 1 == 0
                    });

                    // find all events with monthly repeating flag, having id, repeating at that day few years ago  
                    var yearlyEvents = events.filter(function (event) {
                        return event.repeats === REPEAT_YEARLY &&
                            event.id &&
                            moment(event.start).hour(0).minutes(0).diff(dateTimestamp, 'years', true) % 1 == 0
                    });

                    recurringEvents = monthlyEvents.concat(yearlyEvents);

                    $.each(recurringEvents, function (key, event) {
                        var timeStart = moment(event.start);

                        // Refething event fields for event rendering 
                        var eventData = {
                            id: event.id,
                            allDay: event.allDay,
                            title: event.title,
                            description: event.description,
                            start: date.hour(timeStart.hour()).minutes(timeStart.minutes()).format("YYYY-MM-DD"),
                            end: event.end ? event.end.format("YYYY-MM-DD") : "",
                            className: event.className,
                            repeats: event.repeats
                        };

                        // Removing events to avoid duplication
                        o.$calendar.fullCalendar('removeEvents', function (event) {
                            return eventData.id === event.id &&
                                moment(event.start).isSame(date, 'day');
                        });
                        // Render event
                        o.$calendar.fullCalendar('renderEvent', eventData, true);
                    });
                },
                drop: function (t) {
                    o.onDrop(e(this), t)
                },
                select: function (e, t, n) {
                    o.onSelect(e, t, n)
                },
                eventClick: function (e, t, n) {
                    o.onEventClick(e, t, n)
                }
            }),
                this.$saveCategoryBtn.on("click", function () {
                    var e = o.$categoryForm.find("input[name='category-name']").val(),
                        t = o.$categoryForm.find("select[name='category-color']").val();
                    null !== e && 0 != e.length && (o.$extEvents.append('<div class="external-event bg-' + t + '" data-class="bg-' + t + '" style="position: relative;"><i class="fa fa-move"></i>' + e + "</div>"),
                        o.enableDrag());

                })
        }, e.CalendarApp = new t,
        e.CalendarApp.Constructor = t
}(window.jQuery),
    function (e) {
        "use strict";
        e.CalendarApp.init()
    }(window.jQuery);