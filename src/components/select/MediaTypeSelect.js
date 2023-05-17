import { Select, Space } from 'antd';
    
    const MediaTypeSelect = (props) => {
    
       const options=[
            {
            value: '',
            label: 'Tous',
            },
            {
            value: 'PHOTO',
            label: 'Photo',
            },
            {
            value: 'VIDEO',
            label: 'Video',
            },
        ];
        const handleChange = (value) => {
            props.setCurrentPage(1)
            props.setmediatype(value);
            };
    
   return (
    <Space wrap>
        <Select
        defaultValue={options[0]}
        
        style={{
            width: 120,
        }}
        onChange={handleChange}
        options={options}
        />
    </Space>
)}
export default MediaTypeSelect;