import {useState} from 'react'
import { Input } from 'antd';
const { TextArea } = Input;

const TextAreaInput = (props) => {
    
    const [Brief, setBrief] = useState('');
  return (
    <TextArea
            size='large'
            value={props.content}
            onChange={(e) => props.setvalue(e.target.value)}
            placeholder={props.placeholder}
            autoSize={{
            minRows:props.line_nbr,
            }}
        />
  )
}

export default TextAreaInput