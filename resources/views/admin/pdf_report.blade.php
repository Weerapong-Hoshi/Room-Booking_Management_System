<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานการจองห้อง</title>
    <style>
        body {
            font-family: 'garuda', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #2c3e50;
        }
        
        .header p {
            font-size: 18px;
            margin: 5px 0 0 0;
            color: #7f8c8d;
        }
        
        .date-info {
            text-align: right;
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #2c3e50;
            font-size: 16px;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .room-name {
            font-weight: bold;
            color: #2980b9;
            font-size: 18px;
        }
        
        .user-info {
            font-weight: bold;
            color: #27ae60;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            background-color: #27ae60;
            color: white;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #ecf0f1;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }
        
        .summary h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
            color: #2c3e50;
        }
        
        .summary p {
            margin: 5px 0;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>รายงานการจองห้องเรียนและห้องประชุม</h1>
        <p>ระบบจองห้องเรียนและห้องประชุม</p>
    </div>

    <div class="date-info">
        วันที่ออกรายงาน: {{ now()->format('d/m/Y H:i:s') }}
    </div>

    <div class="summary">
        <h3>สรุปข้อมูล</h3>
        <p>จำนวนการจองทั้งหมด: {{ $bookings->count() }} รายการ</p>
        <p>ช่วงเวลา: ตั้งแต่การจองครั้งแรกจนถึงปัจจุบัน</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 20%;">ห้อง</th>
                <th style="width: 25%;">ผู้จอง</th>
                <th style="width: 20%;">วันที่จอง</th>
                <th style="width: 20%;">เวลาใช้งาน</th>
                <th style="width: 15%;">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr>
                <td>
                    <div class="room-name">{{ $booking->room->name }}</div>
                    <div style="font-size: 14px; color: #666; margin-top: 5px;">
                        ความจุ: {{ $booking->room->capacity }} ที่นั่ง
                    </div>
                </td>
                <td>
                    <div class="user-info">{{ $booking->user->name }}</div>
                    <div style="font-size: 14px; color: #666; margin-top: 5px;">
                        {{ $booking->user->email }}
                    </div>
                    <div style="font-size: 12px; color: #999; margin-top: 3px;">
                        บทบาท: {{ $booking->user->role === 'admin' ? 'ผู้ดูแลระบบ' : 'ผู้ใช้งานทั่วไป' }}
                    </div>
                </td>
                <td>
                    <div><strong>วันที่:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y') }}</div>
                    <div style="font-size: 14px; color: #666; margin-top: 5px;">
                        <strong>จองเมื่อ:</strong> {{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i:s') }}
                    </div>
                </td>
                <td>
                    <div><strong>เริ่ม:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} น.</div>
                    <div><strong>สิ้นสุด:</strong> {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }} น.</div>
                    <div style="font-size: 14px; color: #666; margin-top: 5px;">
                        <strong>รวม:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->diffInHours(\Carbon\Carbon::parse($booking->end_time)) }} ชั่วโมง
                    </div>
                </td>
                <td>
                    <span class="status-badge">ยืนยันแล้ว</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #999; font-style: italic;">
                    ไม่มีข้อมูลการจอง
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>รายงานนี้สร้างโดยระบบจองห้องเรียนและห้องประชุม</p>
        <p>กรุณาตรวจสอบข้อมูลให้ถูกต้อง หากมีข้อสงสัยโปรดติดต่อผู้ดูแลระบบ</p>
    </div>
</body>
</html>